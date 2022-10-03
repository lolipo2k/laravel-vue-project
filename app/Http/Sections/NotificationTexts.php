<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use AdminColumnFilter;
use App\Models\InsuranceCompany;
use App\Models\Language;
use App\Models\NotificationText;
use App\Models\Taxonomy\FieldsCategory;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;

/**
 * Class Languages
 *
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class NotificationTexts extends Section
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
        return 'fas fa-envelope-open-text';
    }

    public function getTitle()
    {
        return __('Уведомления');
    }

    public function getEditTitle()
    {
        return __('Редактировать уведомление');
    }

    public function getCreateTitle()
    {
        return __('Добавить уведомление');
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
                    AdminColumn::text('alias', 'Событие')
                        ->setWidth(270),
                    AdminColumnEditable::text('title', 'Заголовок'),
                    AdminColumnEditable::textarea('message', 'Сообщение'),
                    AdminColumnEditable::checkbox('to_cabinet', 'Cabinet'),
                    AdminColumnEditable::checkbox('to_email', 'E-Mail'),
                ]
            )->disablePagination();

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
        $tabs->appendTab(new FormElements([
                AdminFormElement::select('alias', 'Событие', NotificationText::EVENT_NAMES),
                AdminFormElement::checkbox('to_cabinet', 'В личный кабинет'),
                AdminFormElement::checkbox('to_email', 'На e-mail'),
                AdminFormElement::text('title', 'Заголовок'),
                AdminFormElement::textarea("message", 'Текст'),
            ]
        ), __('Основные'))->setIcon('<i class="fas fa-envelope-open-text"></i>');

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
