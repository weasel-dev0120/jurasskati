<?php

namespace TypiCMS\Modules\Contactpersons\Facades;

use Illuminate\Support\Facades\Facade;

class Contactpersons extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Contactpersons';
    }
}
