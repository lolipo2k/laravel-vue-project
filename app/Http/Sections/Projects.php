<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminSection;
use App\Imports\ContactsImport;
use App\Models\Admin;
use App\Models\Contacts\BaseRecord;
use App\Models\Taxonomy\Field;
use App\Models\Projects\Project;
use App\Models\Taxonomy\Region;
use App\Models\Taxonomy\RejectReason;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Columns\Column;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;
use const http\Client\Curl\PROXY_HTTP;

/**
 * Class Languages
 *
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Projects extends Section implements Initializable
{

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    public function isDeletable(\Illuminate\Database\Eloquent\Model $model)
    {
        return true;
    }

    public function isCreatable()
    {
        return true;
    }

    public function isEditable(\Illuminate\Database\Eloquent\Model $model)
    {
        return true;
    }

    public function getIcon()
    {
        return 'fas fa-project-diagram';
    }

    public function getTitle()
    {
        return __('Проекты');
    }

    public function getEditTitle()
    {
        return __('Редактирование проекта');
    }

    public function getCreateTitle()
    {
        return __('Добавление проекта');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables();

        $display->setDisplaySearch(true);

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('user.name', __('Автор')),
                AdminColumn::text('company_name', __('Компания')),
                AdminColumn::text('created_at', __('Дата создания')),
            ])->paginate(30);


        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();
        $tabs = AdminDisplay::tabbed();

        // General
        $tabs->appendTab(new FormElements([
            AdminFormElement::columns([
                [
                    AdminFormElement::text('company_name', 'Наименование проекта'),
                    AdminFormElement::number('lead_price', 'Цена лида'),
                    AdminFormElement::selectajax('user_id', 'Автор')
                        ->setModelForOptions(User::class, 'name'),
                    AdminFormElement::select('field_id', 'Тематика проекта')
                        ->setModelForOptions(Field::class, 'name'),
                    AdminFormElement::multiselect('regions', 'Регионы')
                        ->setModelForOptions(Region::class)
                        ->setDisplay('name'),
                    AdminFormElement::multiselect('priorityRegions', 'Приоритетные регионы')
                        ->setModelForOptions(Region::class)
                        ->setDisplay('name'),
                    AdminFormElement::radio('b2b', 'Сегмент')
                        ->setOptions([0 => 'B2C', 1 => 'B2B'])
                        ->setDefaultValue(1),
                    AdminFormElement::date('closed_at', 'Дата завершения'),
                    AdminFormElement::textarea('script', 'Скрипт')->setRows(31),
                ],
                [
                    AdminFormElement::select('status', 'Статус проекта', Project::STATUS_NAMES),
                    AdminFormElement::select('reject_reason_id', 'Причина отклонения')
                        ->setModelForOptions(RejectReason::class, 'name'),
                    AdminFormElement::date('active_to', 'Проект активен до даты'),
//                    AdminFormElement::date('payed_to', 'Проект оплачен до даты'),
                    AdminFormElement::checkbox('make_script', 'Нужен скрипт'),
                    AdminFormElement::checkbox('make_base', 'Нужна база'),
                    AdminFormElement::number('leads', 'Лидов оплачено'),
                    AdminFormElement::number('leads_created', 'Лидов сделано'),
                    AdminFormElement::textarea('target', 'Описание ЦА'),
                    AdminFormElement::textarea('description', 'Описание проекта'),
                    AdminFormElement::textarea('comment', 'Коментарий модератора')
                ]
            ]),
            AdminFormElement::multiselect('criteries', 'Критерии лида', Project::LEAD_CRITERION_NAMES)
                ->mutateValue(function ($value) {
                    return is_array($value)
                        ? array_map(function ($elem) {
                            return (integer)$elem;
                        }, $value)
                        : $value;
                }),
            AdminFormElement::number('criterion_price', 'Минимальный бюджет контракта'),
            AdminFormElement::number('criterion_month', 'Максимальный срок заключения контракта (месяцев)'),
            AdminFormElement::text('criterion_position', 'Должность контактного лица'),
            AdminFormElement::multiselectajax('users', 'Связанные пользователи')
                ->setModelForOptions(User::class, 'name'),
        ]), __('Общие'))->setIcon('<i class="fas fa-cogs"></i>');

        $tabs->appendTab(new FormElements([
            AdminFormElement::columns([
                [
                    AdminFormElement::text("legal_name", 'Юридическое название организации'),
                    AdminFormElement::text("inn", 'ИНН'),
                    AdminFormElement::text("kpp", 'КПП'),
                    AdminFormElement::text("legal_address", 'Юридический адрес'),
                    AdminFormElement::textarea('real_address', 'Фактический адрес')
                        ->setRows(3),
                    AdminFormElement::textarea('address', 'Почтовый адрес')
                        ->setRows(3),
                    AdminFormElement::text('ceo_name', 'ФИО директора'),
                    AdminFormElement::text('site_url', 'Адрес сайта'),
                ],
                [
                    AdminFormElement::text('ceo_fio', 'ФИО ЛПР'),
                    AdminFormElement::text('seo_position', 'Должность ЛПР'),
                    AdminFormElement::text('seo_email', 'E-mail ЛПР'),
                    AdminFormElement::text('seo_phone', 'Телефон ЛПР'),
                ]
            ]),
        ]), __('Данные компании'))->setIcon('<i class="fas fa-building"></i>');


        $baseRecords = AdminSection::getModel(BaseRecord::class)->fireDisplay([
            'projectId' => $id
        ]);

        try {
            $baseRecords->setParameter('user_id', $this->getModel()->user_id);
        } catch (\Throwable $ex) {

        }

        $tabs->appendTab(
            new FormElements([
                    AdminFormElement::columns()->addColumn([
                        $baseRecords,
                    ]),
                    AdminFormElement::file('file', 'Загрузить из файла')
                ]
            ), __('Контакты для обзвона'))->setIcon('<i class="fas fa-headset"></i>');


        $tabs->appendTab(new FormElements([
            AdminFormElement::columns([
            ]),
        ]), __('Лиды проекта'))->setIcon('<i class="fas fa-"></i>');

//        $tabs->appendTab(AdminFormElement::manyToMany('users', [
//            AdminFormElement::select('status', 'Статус', Project::STATUS_NAMES)
//        ])->setRelatedElementDisplayName(function ($model) {
//            return $model->name . ' ' . $model->last_name;
//        }), 'Сотрудники')->setIcon('<i class="fas fa-user-tie"></i>');


//        $tabs->appendTab(AdminFormElement::manyToMany('users', [
//            AdminFormElement::select('status', 'Статус', Project::STATUS_NAMES)
//        ])->setRelatedElementDisplayName(function ($model) {
//            return $model->name . ' ' . $model->last_name;
//        }), 'Сотрудники')->setIcon('<i class="fas fa-user-tie"></i>');
//
        $form->addElement($tabs);


        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    public function initialize()
    {
        $initStatus = 0;
        $this->registerEvent('saving', function ($config, Project $p) use ($initStatus) {
            $initStatus = $p->status;
        });

        $this->registerEvent('saved', function ($config, Project $p) use ($initStatus) {
            if ($p->file) {
                $import = new ContactsImport(true, $p->id);
                Excel::import($import, $p->file);

                $p->file = null;
                $p->save();
            }
            if ($p->status == Project::STATUS_MODERATED) {
                if ($p->status != $initStatus) {
                    $p->payed_to = now()->addMonth();
                    $p->save();
                }
            }
        });
    }
}
