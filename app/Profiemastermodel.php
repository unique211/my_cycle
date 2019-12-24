<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiemastermodel extends Model
{
    //
    public $primaryKey = 'profile_id';
    protected $table = "profile_master";
    protected $fillable = [
        'profile_type', 'user_id','status'
    ];
}
