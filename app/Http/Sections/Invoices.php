<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminSection;
use App\Models\Admin;
use App\Models\Payments\Invoice;
use App\Models\Taxonomy\Field;
use App\Models\Projects\Project;
use App\Models\Taxonomy\Region;
use App\Models\Taxonomy\RejectReason;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
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
class Invoices extends Section implements Initializable
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
        return false;
    }

    public function isCreatable()
    {
        return false;
    }

    public function isEditable(\Illuminate\Database\Eloquent\Model $model)
    {
        return true;
    }

    public function getIcon()
    {
        return 'fas fa-file-invoice';
    }

    public function getTitle()
    {
        return __('Счета');
    }

    public function getEditTitle()
    {
        return __('Редактирование счета');
    }

    public function getCreateTitle()
    {
        return __('Создание счета');
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
                AdminColumn::relatedLink('user.name', __('Клиент')),
                AdminColumn::relatedLink('project.company_name', __('Проект')),
                AdminColumn::text('amount', 'Сумма'),
                AdminColumn::text('typeText', __('Тип оплаты'))
                    ->setSearchable(false)
                    ->setOrderable(false),
                AdminColumn::text('statusText', __('Статус'))
                    ->setSearchable(false)
                    ->setOrderable(false),
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
                    AdminFormElement::selectajax('user_id', 'Клиент')
                        ->setModelForOptions(User::class, 'name')
                        ->setReadonly(true),
                    AdminFormElement::text('project.company_name', 'Проект')->setReadonly(true),
                    AdminFormElement::number('amount', 'Сумма'),
                    AdminFormElement::select('status', 'Статус')
                        ->setOptions(Invoice::STATUS_NAMES),
                    AdminFormElement::checkbox('for_rate', 'Включает базовый тариф'),
                    AdminFormElement::checkbox('for_contacts', 'Включает базу контактов'),
                    AdminFormElement::number('for_leads', 'Количество лидов'),
                ],
                [
                    AdminFormElement::file('invoice', 'Счет'),
                    AdminFormElement::file('check', 'Чек'),
                    AdminFormElement::text('created_at', 'Дата создания')->setReadonly(true),
                ]
            ]),
        ]), __('Общие'))->setIcon('<i class="fas fa-cogs"></i>');

//        $tabs->appendTab(new FormElements([
//            AdminFormElement::columns([
//                [
//                    AdminFormElement::text("legal_name", 'Юридическое название организации'),
//                    AdminFormElement::text("inn", 'ИНН'),
//                    AdminFormElement::text("kpp", 'КПП'),
//                    AdminFormElement::text("legal_address", 'Юридический адрес'),
//                    AdminFormElement::textarea('real_address', 'Фактический адрес')
//                        ->setRows(3),
//                    AdminFormElement::textarea('address', 'Почтовый адрес')
//                        ->setRows(3),
//                    AdminFormElement::text('ceo_name', 'ФИО директора'),
//                    AdminFormElement::text('site_url', 'Адрес сайта'),
//                ],
//                [
//                    AdminFormElement::text('ceo_fio', 'ФИО ЛПР'),
//                    AdminFormElement::text('seo_position', 'Должность ЛПР'),
//                    AdminFormElement::text('seo_email', 'E-mail ЛПР'),
//                    AdminFormElement::text('seo_phone', 'Телефон ЛПР'),
//                ]
//            ]),
//        ]), __('Данные компании'))->setIcon('<i class="fas fa-building"></i>');
//        $tabs->appendTab(new FormElements([
//            AdminFormElement::columns([
//            ]),
//        ]), __('Лиды проекта'))->setIcon('<i class="fas fa-"></i>');

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
//        $initStatus = 0;
//        $this->registerEvent('saving', function ($config, Project $p) use ($initStatus) {
//            $initStatus = $p->status;
//        });
//
//        $this->registerEvent('saved', function ($config, Project $p) use ($initStatus) {
//            if ($p->status == Project::STATUS_MODERATED) {
//                if ($p->status != $initStatus) {
//                    $p->payed_to = now()->addMonth();
//                    $p->save();
//                }
//            }
//        });
    }

}
