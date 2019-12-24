<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membermodel extends Model
{
    //
    public $primaryKey = 'member_id';
    protected $table = "member_master";
    protected $fillable = [
        'membername','icno','dob','address','email','currentpackage','membertype','dateofexpire','balancepoint', 'status', 'user_id','image_url'
    ];
}
