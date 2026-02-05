<?php

namespace TypiCMS\Modules\Flats\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Flats\Composers\SidebarViewComposer;
use TypiCMS\Modules\Flats\Facades\Flats;
use TypiCMS\Modules\Flats\Models\Flat;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flats.php', 'typicms.modules.flats');

        $this->loadViewsFrom(resource_path('views'), 'flats');

        AliasLoader::getInstance()->alias('Flats', Flats::class);

        // Observers
        // Flat::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('flats::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('flats');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Flats', Flat::class);
    }
}
