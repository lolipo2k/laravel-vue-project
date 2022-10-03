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
class Users extends Section
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
        return $model->role == User::ROLE_MODERATOR;
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
        return 'fas fa-users';
    }

    public function getTitle()
    {
        return __('Пользователи');
    }

    public function getEditTitle()
    {
        return __('Редактирование пользователя');
    }

    public function getCreateTitle()
    {
        return __('Добавление пользователя');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables();

//        $display->setDisplaySearch(true);
        $display->getScopes()->push('notAdmin');


        $display->setColumnFilters([
            null, // Не ищем по первому столбцу
            null,

            // Поиск текста
            AdminColumnFilter::text()->setPlaceholder('Введите имя')
                ->setOperator(FilterInterface::CONTAINS),
            AdminColumnFilter::text()->setPlaceholder('Введите фамилию')
                ->setOperator(FilterInterface::CONTAINS),
            AdminColumnFilter::select()
                ->setOptions(User::ROLE_NAMES)
                ->multiple()
                ->setPlaceholder('Выберите роли'),
            AdminColumnFilter::text()->setPlaceholder('Введите телефон')
                ->setOperator(FilterInterface::CONTAINS),
            AdminColumnFilter::text()->setPlaceholder('Введите E-mail')
                ->setOperator(FilterInterface::CONTAINS),
            AdminColumnFilter::select()->setPlaceholder('Категория')
                ->setModelForOptions(FieldsCategory::class, 'name')
                ->setColumnName('fieldCategories.id')
                ->multiple(),
            AdminColumnFilter::select()->setPlaceholder('Опыт работы')
                ->setModelForOptions(WorkExperience::class, 'name')
                ->setColumnName('workExperience.id')
                ->multiple(),
            // Поиск по выпадающему списку значений
//            AdminColumnFilter::select(new Country, 'Title')->setDisplay('title')->setPlaceholder('Select Country')->setColumnName('country_id')
        ]);

        $display->getColumnFilters()->setPlacement("table.header");

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::image('avatar')->setImageWidth(70),
                AdminColumn::text('name', __('Имя')),
                AdminColumn::text('last_name', __('Фамилия')),
                AdminColumn::custom('Роль', function ($model) {
                    return User::ROLE_NAMES[$model->role];
                })
                    ->setSearchable(true)
                    ->setSearchCallback(function ($column, $query, $search) {
                        $statuses = collect(User::ROLE_NAMES)->filter(function ($status) use ($search) {
                            return mb_strpos(mb_strtolower($status), mb_strtolower($search)) !== false;
                        })->keys();
                        return $query->orWhereIn('role', $statuses);
                    })
                    ->setName('role')
                    ->setWidth(130),
                AdminColumn::text('phone', __('Телефон')),
                AdminColumn::text('email', 'E-Mail'),
                AdminColumn::lists('fieldCategories.name', 'Категории')
                    ->setWidth(200),
                AdminColumn::lists('workExperience.name', 'Опыт работы')
                    ->setWidth(150),
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
                    AdminFormElement::text('email', 'E-Mail'),
                    AdminFormElement::select('role', 'Роль', User::ROLE_NAMES),
                    AdminFormElement::checkbox('own', 'Наш сотрудник'),
                    AdminFormElement::text('name', 'Имя'),
                    AdminFormElement::text('last_name', 'Фамилия'),
                    AdminFormElement::text('phone', 'Телефон'),
                    AdminFormElement::checkbox('phone_confirmed', 'Телефон подтвержден'),
                    AdminFormElement::checkbox('learned', 'Обучение пройдено (для сотрудников)'),
                    AdminFormElement::password('password', 'Пароль')->hashWithBcrypt()
                        ->allowEmptyValue()
                ],
                [
                    AdminFormElement::number('balance', 'Баланс аккаунта'),
                    AdminFormElement::checkbox('payment_status', 'Оплачен'),
                    AdminFormElement::timestamp('active_to', 'Оплачен до'),
                    AdminFormElement::image('avatar', 'Avatar'),
                    AdminFormElement::select('moderator_id', 'Модератор')
                        ->setModelForOptions(User::class, 'name')
                        ->setLoadOptionsQueryPreparer(function ($element, $q) {
                            return $q->where('role', User::ROLE_MODERATOR);
                        }),
//                    AdminFormElement::multiselect('fields', 'Тематики')
//                        ->setModelForOptions(\App\Models\Taxonomy\Field::class, 'name'),
                    AdminFormElement::multiselect('fieldCategories', 'Категории')
                        ->setModelForOptions(\App\Models\Taxonomy\FieldsCategory::class, 'name'),
                    AdminFormElement::multiselect('workExperience', 'Опыт работы')
                        ->setModelForOptions(\App\Models\Taxonomy\WorkExperience::class, 'name')
                ]
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
