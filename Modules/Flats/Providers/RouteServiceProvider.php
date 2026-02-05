<?php

namespace TypiCMS\Modules\Flats\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Flats\Http\Controllers\AdminController;
use TypiCMS\Modules\Flats\Http\Controllers\ApiController;
use TypiCMS\Modules\Flats\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('flats')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-flats');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('flat');
                    });
                }
            }
        }

        foreach (locales() as $lang) {
            Route::middleware('public')->prefix($lang.'/flats')->name($lang.'::')->group(function (Router $router) {
                $router->get('dowload/{id}', [PublicController::class, 'download'])->name('download-flat');
            });
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('flats', [AdminController::class, 'index'])->name('index-flats')->middleware('can:read flats');
            $router->get('flats/export', [AdminController::class, 'export'])->name('export-flats')->middleware('can:read flats');
            $router->get('flats/create', [AdminController::class, 'create'])->name('create-flat')->middleware('can:create flats');
            $router->get('flats/{flat}/edit', [AdminController::class, 'edit'])->name('edit-flat')->middleware('can:read flats');
            $router->post('flats', [AdminController::class, 'store'])->name('store-flat')->middleware('can:create flats');
            $router->put('flats/{flat}', [AdminController::class, 'update'])->name('update-flat')->middleware('can:update flats');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('flats', [ApiController::class, 'index'])->middleware('can:read flats');
            $router->patch('flats/{flat}', [ApiController::class, 'updatePartial'])->middleware('can:update flats');
            $router->delete('flats/{flat}', [ApiController::class, 'destroy'])->middleware('can:delete flats');
        });
    }
}
