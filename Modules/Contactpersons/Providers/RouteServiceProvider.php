<?php

namespace TypiCMS\Modules\Contactpersons\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Contactpersons\Http\Controllers\AdminController;
use TypiCMS\Modules\Contactpersons\Http\Controllers\ApiController;
use TypiCMS\Modules\Contactpersons\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('contactpersons')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-contactpersons');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('contactperson');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('contactpersons', [AdminController::class, 'index'])->name('index-contactpersons')->middleware('can:read contactpersons');
            $router->get('contactpersons/export', [AdminController::class, 'export'])->name('export-contactpersons')->middleware('can:read contactpersons');
            $router->get('contactpersons/create', [AdminController::class, 'create'])->name('create-contactperson')->middleware('can:create contactpersons');
            $router->get('contactpersons/{contactperson}/edit', [AdminController::class, 'edit'])->name('edit-contactperson')->middleware('can:read contactpersons');
            $router->post('contactpersons', [AdminController::class, 'store'])->name('store-contactperson')->middleware('can:create contactpersons');
            $router->put('contactpersons/{contactperson}', [AdminController::class, 'update'])->name('update-contactperson')->middleware('can:update contactpersons');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('contactpersons', [ApiController::class, 'index'])->middleware('can:read contactpersons');
            $router->patch('contactpersons/{contactperson}', [ApiController::class, 'updatePartial'])->middleware('can:update contactpersons');
            $router->delete('contactpersons/{contactperson}', [ApiController::class, 'destroy'])->middleware('can:delete contactpersons');
        });
    }
}
