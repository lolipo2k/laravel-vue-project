<?php

namespace App\Providers;

use App\Http\Sections\System\ContactStatuses;
use App\Models\Projects\ContactStatus;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        //\App\Models\User::class => 'App\Http\Sections\Users',
        \App\Models\User::class => \App\Http\Sections\Users::class,
        \App\Models\Admin::class => \App\Http\Sections\Admins::class,
        \App\Models\Taxonomy\Region::class => \App\Http\Sections\System\Regions::class,
        \App\Models\Taxonomy\FieldsCategory::class => \App\Http\Sections\System\FieldsCategories::class,
        \App\Models\Taxonomy\Field::class => \App\Http\Sections\System\Fields::class,
        \App\Models\Taxonomy\WorkExperience::class => \App\Http\Sections\System\WorkExperience::class,
        \App\Models\Taxonomy\RejectReason::class => \App\Http\Sections\System\RejectReasons::class,
        \App\Models\Projects\ContactStatus::class => \App\Http\Sections\System\ContactStatuses::class,
        \App\Models\Projects\Project::class => \App\Http\Sections\Projects::class,
        \App\Models\Projects\ModeratedProject::class => \App\Http\Sections\ModeratedProjects::class,
        \App\Models\Projects\ProjectUser::class => \App\Http\Sections\ProjectModeration::class,
        \App\Models\Contacts\Contact::class => \App\Http\Sections\Contacts::class,
        \App\Models\Support::class => \App\Http\Sections\Support::class,
        \App\Models\Payments\Invoice::class => \App\Http\Sections\Invoices::class,
        \App\Models\Contacts\BaseRecord::class => \App\Http\Sections\BaseRecords::class,
        \App\Models\Contacts\BaseRecordStatus::class => \App\Http\Sections\BaseRecordStatuses::class,
        \App\Models\Payments\Withdraw::class => \App\Http\Sections\Withdraws::class,
        \App\Models\NotificationText::class => \App\Http\Sections\NotificationTexts::class,
    ];

    protected $widgets = [
        \Admin\Widgets\NavigationUserBlock::class,
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        //
        $this->loadViewsFrom(base_path("Admin/resources/views"), 'admin');
        parent::boot($admin);
//        $this->app->call([$this, 'registerViews']);

    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
