<?php

namespace TypiCMS\Modules\Contactpersons\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Contactpersons\Composers\SidebarViewComposer;
use TypiCMS\Modules\Contactpersons\Facades\Contactpersons;
use TypiCMS\Modules\Contactpersons\Models\Contactperson;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/contactpersons.php', 'typicms.modules.contactpersons');

        $this->loadViewsFrom(resource_path('views'), 'contactpersons');

        AliasLoader::getInstance()->alias('Contactpersons', Contactpersons::class);

        // Observers
        // Contactperson::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('contactpersons::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('contactpersons');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Contactpersons', Contactperson::class);
    }
}
