<?php

namespace TypiCMS\Modules\Flats\Models;

use TypiCMS\Modules\Core\Models\Base;


class FlatReserveInfo extends Base
{
    

    protected $guarded = [];
    
    protected $table = 'flat_reserve_info';

    protected $fillable = [
	    'name',
	    'last_name',
	    'email',
	    'company_name',
	    'code',
	    'phone',
	    'payment_method',
	    'payment_id',
	    'amount',
	    'status',
	    'flat_id',
	];

    
   
}
