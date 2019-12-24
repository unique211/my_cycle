<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loginmastermodel extends Model
{
    //
    public $primaryKey = 'login_id';
    protected $table = "login_master";
    protected $fillable = [
        'ref_id','password', 'role','status','user_id',
    ];
}
