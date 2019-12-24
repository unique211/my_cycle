<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packagemodel extends Model
{
    //for define table name
    public $primaryKey = 'packege_id';
    protected $table = "package_master";
    protected $fillable = [
        'package_name', 'package_point', 'package_price','status','user_id'
    ];
}
