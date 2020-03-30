<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worklist extends Model
{
    //
    protected $fillable = [
        'schedule_list_code', 'worker', 'point_check', 'description', 'percent', 'status_check', 'comment', 'date_check'
    ];
}