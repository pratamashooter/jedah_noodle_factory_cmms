<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Improvement extends Model
{
    //
    protected $fillable = [
        'id_user', 'user', 'repair_code', 'repair_date', 'lane', 'machine', 'title', 'description', 'status'
    ];
}
