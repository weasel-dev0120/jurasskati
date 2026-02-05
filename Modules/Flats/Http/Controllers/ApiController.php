<?php

namespace TypiCMS\Modules\Flats\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Flats\Models\Flat;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        return QueryBuilder::for(Flat::class)
            ->select(['id', 'image_id', 'number', 'total_area', 'price', 'availability'])
            ->allowedSorts(['number', 'total_area', 'price', 'availability'])
            ->allowedFilters([
                AllowedFilter::custom('number', new FilterOr()),
                AllowedFilter::exact('availability'),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));
    }

    protected function updatePartial(Flat $flat, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($flat->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $flat->setTranslation($key, $lang, $value);
                }
            } else {
                $flat->{$key} = $content;
            }
        }

        $flat->save();
    }

    public function destroy(Flat $flat)
    {
        $flat->delete();
    }
}