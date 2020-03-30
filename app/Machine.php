<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    //
    protected $fillable = [
        'machine_code', 'lane', 'machine_name', 'brand', 'capacity', 'production_year'
    ];
}
