<?php

namespace TypiCMS\Modules\Galleries\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read galleries')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Galleries'), function (SidebarItem $item) {
                $item->id = 'galleries';
                $item->icon = config('typicms.modules.galleries.sidebar.icon');
                $item->weight = config('typicms.modules.galleries.sidebar.weight');
                $item->route('admin::index-galleries');
                $item->append('admin::create-gallery');
            });
        });
    }
}
