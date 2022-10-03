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
class ModeratedProjects extends Projects
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
        return false;
    }

    public function isEditable(\Illuminate\Database\Eloquent\Model $model)
    {
        return true;
    }

    public function getIcon()
    {
        return 'fas fa-hand-holding-usd';
    }

    public function getTitle()
    {
        return __('Модерация проектов');
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
    public function onDisplay3()
    {
        $display = AdminDisplay::datatables();

        $display->setDisplaySearch(true);

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('user.name', __('Автор')),
                AdminColumn::text('company_name', __('Компания')),
            ])->paginate(30);


        return $display;
    }
}
