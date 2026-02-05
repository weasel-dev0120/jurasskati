<?php

namespace TypiCMS\Modules\Contactpersons\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read contactpersons')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Contactpersons'), function (SidebarItem $item) {
                $item->id = 'contactpersons';
                $item->icon = config('typicms.modules.contactpersons.sidebar.icon');
                $item->weight = config('typicms.modules.contactpersons.sidebar.weight');
                $item->route('admin::index-contactpersons');
                $item->append('admin::create-contactperson');
            });
        });
    }
}
