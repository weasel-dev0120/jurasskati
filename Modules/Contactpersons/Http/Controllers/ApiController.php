<?php

namespace TypiCMS\Modules\Contactpersons\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Contactpersons\Models\Contactperson;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Contactperson::class)
            ->selectFields($request->input('fields.contactpersons'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Contactperson $contactperson, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($contactperson->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $contactperson->setTranslation($key, $lang, $value);
                }
            } else {
                $contactperson->{$key} = $content;
            }
        }

        $contactperson->save();
    }

    public function destroy(Contactperson $contactperson)
    {
        $contactperson->delete();
    }
}
