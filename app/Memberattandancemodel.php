<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberattandancemodel extends Model
{
    //

    public $primaryKey = 'attadance_id';
    protected $table = "meber_attandance";
    protected $fillable = [
        'class_sechedule_id','starttime','endtime','attdancedate','userid','status'
    ];
}
