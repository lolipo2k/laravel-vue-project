<?php

namespace App\Http\Sections\System;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use AdminColumnFilter;
use App\Models\InsuranceCompany;
use App\Models\Language;
use App\Models\Taxonomy\Field;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Languages
 *
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class FieldsCategories extends Section
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
        return 'fas fa-network-wired';
    }

    public function getTitle()
    {
        return __('Категории тематик');
    }

    public function getEditTitle()
    {
        return __('Редактировать категорию');
    }

    public function getCreateTitle()
    {
        return __('Добавить категорию');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables();

        $display->setDisplaySearch(true);

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('name', 'Название')
            )->paginate(30);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()
            ->addBody([
                AdminFormElement::text('name', 'Название'),
                AdminFormElement::multiselect('fields', 'Тематики проекта')
                    ->setModelForOptions(Field::class, 'name')
            ]);
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
