<?php

namespace TypiCMS\Modules\Galleries\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Galleries\Composers\SidebarViewComposer;
use TypiCMS\Modules\Galleries\Facades\Galleries;
use TypiCMS\Modules\Galleries\Models\Gallery;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/galleries.php', 'typicms.modules.galleries');

        $this->loadViewsFrom(resource_path('views'), 'galleries');

        AliasLoader::getInstance()->alias('Galleries', Galleries::class);

        // Observers
        // Gallery::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('galleries::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('galleries');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Galleries', Gallery::class);
    }
}
