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
use App\Models\Projects\Project;
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
class ProjectModeration extends Section
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
        return 'fas fa-user-shield';
    }

    public function getTitle()
    {
        return __('Заявки на проекты');
    }

    public function getEditTitle()
    {
        return __('Редактирование заявки');
    }

    public function getCreateTitle()
    {
        return __('Добавление заявки');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables();

        $display->setDisplaySearch(true);

        $display->getScopes()->push('isNew');

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
//                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::custom('Клиент', function ($model) {
                    return $model->project->user->name;
                }),
                AdminColumn::relatedLink('project.company_name', 'Компания'),
                AdminColumn::relatedLink('user.name', 'Cотрудник'),
                AdminColumnEditable::select('status', 'Статус', Project::STATUS_NAMES),
            ])->paginate(30)
            ->with(['project', 'user']);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            '<label>Клиент</label>',
            AdminColumn::custom('Клиент:', function ($model) {
                return $model->project->user->name;
            }),
            '<label>Компания:</label>',
            AdminColumn::relatedLink('project.company_name', 'Компания'),
            '<label>Сотрудник:</label>',
            AdminColumn::relatedLink('user.name', 'Cотрудник'),
            AdminFormElement::select('status', 'Статус', Project::STATUS_NAMES),
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
