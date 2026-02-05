<?php

namespace TypiCMS\Modules\Contactpersons\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Contactpersons\Models\Contactperson;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Contactperson::published()->order()->with('image')->get();

        return view('contactpersons::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Contactperson::published()->whereSlugIs($slug)->firstOrFail();

        return view('contactpersons::public.show')
            ->with(compact('model'));
    }
}
