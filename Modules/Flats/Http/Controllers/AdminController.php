<?php

namespace TypiCMS\Modules\Flats\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Flats\Exports\Export;
use TypiCMS\Modules\Flats\Http\Requests\FormRequest;
use TypiCMS\Modules\Flats\Models\Flat;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('flats::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' flats.xlsx';

        return Excel::download(new Export(), $filename);
    }

    public function create(): View
    {
        $model = new Flat();

        return view('flats::admin.create')
            ->with(compact('model'));
    }

    public function edit(flat $flat): View
    {
        return view('flats::admin.edit')
            ->with(['model' => $flat]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $input = $request->validated();
        $flat = Flat::create($input);

        return $this->redirect($request, $flat)
            ->withMessage(__('Item successfully created.'));
    }

    public function update(flat $flat, FormRequest $request): RedirectResponse
    {
        $input = $request->validated();
        $flat->update($input);

        return $this->redirect($request, $flat)
            ->withMessage(__('Item successfully updated.'));
    }
}
