<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annualschedulelist extends Model
{
    //
    protected $fillable = [
        'schedule_list_code', 'schedule_code', 'id_user', 'lane', 'machine_code', 'schedule_date', 'status'
    ];
}
