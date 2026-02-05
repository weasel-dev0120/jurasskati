<?php

namespace TypiCMS\Modules\Flats\Facades;

use Illuminate\Support\Facades\Facade;

class Flats extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Flats';
    }
}
