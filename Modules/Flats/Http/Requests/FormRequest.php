<?php

namespace TypiCMS\Modules\Flats\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image_id' => 'nullable|integer',
            'second_image_id' => 'nullable|integer',
            'third_image_id' => 'nullable|integer',
            'number' => 'required|max:255',
            'floor' => 'required|numeric',
            'floor_location' => 'required|numeric',
            'availability' => 'integer|nullable',
            'has_second_floor' => 'nullable|boolean',
            'second_floor_location' => 'required_with:has_second_floor|numeric',
            'has_third_floor' => 'nullable|boolean',
            'third_floor_location' => 'required_with:has_third_floor|numeric',
            'room_count' => 'required|numeric',
            'type' => 'required',
            'total_area' => 'required|decimal:0,3',
            // 'living_area' => 'required|decimal:0,3',
            'outdoor_area' => 'nullable|decimal:0,3',
            'price' => 'nullable|decimal:0,2',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'summary.*' => 'nullable',
            'body.*' => 'nullable',
        ];
    }
}
