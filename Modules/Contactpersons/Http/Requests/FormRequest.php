<?php

namespace TypiCMS\Modules\Contactpersons\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image_id' => 'nullable|integer',
            'title.*' => 'required|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255',
            'status.*' => 'boolean',
            'summary.*' => 'nullable',
            'body.*' => 'nullable',
            'position.*' => 'required|max:255',
            'email' => 'email|nullable',
            'phone' => 'nullable',
        ];
    }
}
