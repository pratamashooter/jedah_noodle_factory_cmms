<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annualschedule extends Model
{
    //
    protected $fillable = [
        'schedule_code', 'id_user', 'lane', 'machine_code', 'time', 'period', 'start_date'
    ];
}
