<?php

namespace TypiCMS\Modules\Flats\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read flats')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Flats'), function (SidebarItem $item) {
                $item->id = 'flats';
                $item->icon = config('typicms.modules.flats.sidebar.icon');
                $item->weight = config('typicms.modules.flats.sidebar.weight');
                $item->route('admin::index-flats');
                $item->append('admin::create-flat');
            });
        });
    }
}
