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
use App\Models\Company\Company;
use App\Models\Company\CompanyDepartment;
use App\Models\Company\CompanyGroup;
use App\Models\Company\Field;
use App\Models\Company\Industry;
use App\Models\Company\JobPost;
use App\Models\Company\Position;
use App\Models\Company\VacancyResponsible;
use App\Models\CoreValues\CoreValue;
use App\Models\Course\Course;
use App\Models\InsuranceCompany;
use App\Models\Language;
use App\Models\Payments\Withdraw;
use App\Models\Skills\Skill;
use App\Models\Taxonomy\FieldsCategory;
use App\Models\Taxonomy\WorkExperience;
use App\Models\User;
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
class Withdraws extends Section
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
        return false;
    }

    public function getIcon()
    {
        return 'fas fa-cash-register';
    }

    public function getTitle()
    {
        return __('Запросы на выплату');
    }

    public function getEditTitle()
    {
        return __('Редактирование запроса на выплату');
    }

    public function getCreateTitle()
    {
        return __('Добавление запроса на выплату');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay($payload)
    {
        $display = AdminDisplay::datatables();

        $display->addScript('default', '/js/withdraw.js');

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::relatedLink('employee.name', __('Сотрудник')),
                AdminColumn::text('amount', __('сумма')),
                AdminColumn::custom(__('Статус'), function ($model) {
                    return Withdraw::STATUS_NAMES[$model->status];
                }),
                AdminColumn::text('created_at', __('Создан')),
                AdminColumn::custom('', function ($model) {
                    if ($model->status) {
                        return '';
                    }

                    $actions = "<a href='javascript://' onclick='pxWithdrawConfirm({$model->id})'>Подтвердить</a><br />";
                    $actions .= "<a href='javascript://' onclick='pxWithdrawCancel({$model->id})'>Отменить</a><br />";
                    return $actions;
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
                    AdminFormElement::hidden('project_id'),
                    AdminFormElement::hidden('user_id'),
                    AdminFormElement::text('company', __('Название компании')),
                    AdminFormElement::textarea('phones', __('Телефоны')),
                    AdminFormElement::textarea('names', __('Контакты')),
                    AdminFormElement::textarea('info', __('Коментарии')),
                ],
            ])]), __('Общие'))->setIcon('<i class="fas fa-user"></i>');


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
