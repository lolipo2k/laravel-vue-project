<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\Models\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\Models\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\Models\User::class)

return [
    [
        'title' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'url' => route('admin.dashboard'),
    ],
    (new Page(\App\Models\User::class)),
    (new Page(\App\Models\Projects\ProjectUser::class))
        ->addBadge(function () {
            return \App\Models\Projects\ProjectUser::isNew()->count();
        }),
    (new Page(\App\Models\Contacts\Contact::class))
        ->addBadge(function () {
            return \App\Models\Contacts\Contact::count();
        }),
    (new Page(\App\Models\Projects\Project::class)),
    (new Page(\App\Models\Payments\Invoice::class)),
    (new Page(\App\Models\Projects\ModeratedProject::class))->addBadge(function () {
        return \App\Models\Projects\ModeratedProject::count();
    }),
    (new Page(\App\Models\Contacts\BaseRecordStatus::class)),
    (new Page(\App\Models\Payments\Withdraw::class)),
    (new Page(\App\Models\Support::class)),
    ['title' => __('Системные настройки'),
        'icon' => 'fa fa-cogs',
        'id' => 'settings-section',
        'priority' => 5000,
        'pages' => [
            (new Page(\App\Models\Admin::class)),
            (new Page(\App\Models\NotificationText::class )),
            (new Page(\App\Models\Taxonomy\RejectReason::class)),
            (new Page(\App\Models\Projects\ContactStatus::class)),
            (new Page(\App\Models\Taxonomy\Region::class)),
            (new Page(\App\Models\Taxonomy\FieldsCategory::class)),
            (new Page(\App\Models\Taxonomy\Field::class)),
            (new Page(\App\Models\Taxonomy\WorkExperience::class)),
        ]
    ]
    // Examples
    // [
    //    'title' => 'Content',
    //    'pages' => [
    //
    //        \App\Models\User::class,
    //
    //        // or
    //
    //        (new Page(\App\Models\User::class))
    //            ->setPriority(100)
    //            ->setIcon('fas fa-users')
    //            ->setUrl('users')
    //            ->setAccessLogic(function (Page $page) {
    //                return auth()->user()->isSuperAdmin();
    //            }),
    //
    //        // or
    //
    //        new Page([
    //            'title'    => 'News',
    //            'priority' => 200,
    //            'model'    => \App\News::class
    //        ]),
    //
    //        // or
    //        (new Page(/* ... */))->setPages(function (Page $page) {
    //            $page->addPage([
    //                'title'    => 'Blog',
    //                'priority' => 100,
    //                'model'    => \App\Blog::class
    //		      ));
    //
    //		      $page->addPage(\App\Blog::class);
    //	      }),
    //
    //        // or
    //
    //        [
    //            'title'       => 'News',
    //            'priority'    => 300,
    //            'accessLogic' => function ($page) {
    //                return $page->isActive();
    //		      },
    //            'pages'       => [
    //
    //                // ...
    //
    //            ]
    //        ]
    //    ]
    // ]
];
