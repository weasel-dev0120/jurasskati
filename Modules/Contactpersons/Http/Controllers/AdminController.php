<?php

namespace TypiCMS\Modules\Contactpersons\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Contactpersons\Exports\Export;
use TypiCMS\Modules\Contactpersons\Http\Requests\FormRequest;
use TypiCMS\Modules\Contactpersons\Models\Contactperson;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('contactpersons::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' contactpersons.xlsx';

        return Excel::download(new Export(), $filename);
    }

    public function create(): View
    {
        $model = new Contactperson();

        return view('contactpersons::admin.create')
            ->with(compact('model'));
    }

    public function edit(contactperson $contactperson): View
    {
        return view('contactpersons::admin.edit')
            ->with(['model' => $contactperson]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        // dd($request->validated());
        $contactperson = Contactperson::create($request->validated());

        return $this->redirect($request, $contactperson)
            ->withMessage(__('Item successfully created.'));
    }

    public function update(contactperson $contactperson, FormRequest $request): RedirectResponse
    {
        $contactperson->update($request->validated());

        return $this->redirect($request, $contactperson)
            ->withMessage(__('Item successfully updated.'));
    }
}
