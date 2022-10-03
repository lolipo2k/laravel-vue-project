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
use App\Models\Taxonomy\Field;
use App\Models\Projects\Project;
use App\Models\Taxonomy\Region;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Form\Columns\Column;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;

/**
 * Class Languages
 *
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts extends Section
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
        return true;
    }

    public function isEditable(\Illuminate\Database\Eloquent\Model $model)
    {
        return true;
    }

    public function getIcon()
    {
        return 'fas fa-address-card';
    }

    public function getTitle()
    {
        return __('Пул компаний');
    }

    public function getEditTitle()
    {
        return __('Редактирование компании');
    }

    public function getCreateTitle()
    {
        return __('Добавление компании');
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
                AdminColumn::text('company_name', __('Компания')),
                AdminColumn::text('region.name', __('Регион'))
                    ->setSearchCallback(function ($column, $query, $search) {
                        return $query->orWhereHas('region', function ($q) use ($search) {
                            return $q->where('name', 'like', "%$search%");
                        });
                    }),
                AdminColumn::text('field.name', __('Тематика'))
                    ->setSearchCallback(function ($column, $query, $search) {
                        $query->orWhereHas('field', function ($q) use ($search) {
                            $q->where('name', 'like', "%$search%");
                        });
                    }),
                AdminColumn::lists('persons.name', 'Контактные лица')
                    ->setSearchable(true)
                    ->setSearchCallback(function ($column, $query, $search) {
                        $query->orWhereHas('persons', function ($q) use ($search) {
                            $q->where('name', 'like', "%$search%");
                        });
                    })
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
                    AdminFormElement::text('company_name', 'Название компании'),
                    AdminFormElement::text('site', 'Сайт'),
                    AdminFormElement::select('field_id', 'Тематика проекта')
                        ->setModelForOptions(Field::class, 'name'),
                    AdminFormElement::select('region_id', 'Регионы')
                        ->setModelForOptions(Region::class)
                        ->setDisplay('name'),
                ],
                [
                    AdminFormElement::textarea('comment', 'Комментарий')
                        ->setHelpText('Максимальная длинна 255 символов')
                        ->setValidationRules('max:255')
                ]
            ]),
        ]), __('Общие'))->setIcon('<i class="fas fa-address-card"></i>');


        $tabs->appendTab(AdminFormElement::hasMany('persons', [
            AdminFormElement::text('name', 'Имя'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('email', 'E-Mail'),
            AdminFormElement::text('position', 'Должность'),
            AdminFormElement::select('status', 'Статус', [
                0 => 'Исходный',
                1 => 'Изменен оператором',
                2 => 'Удален оператором',
                3 => 'Добавлен оператором',
            ])->setDefaultValue(0),
            AdminFormElement::text('comment', 'Комментарий'),
        ]), 'Контактные данные')->setIcon('<i class="fas fa-fingerprint"></i>');

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
}
