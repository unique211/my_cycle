<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Useraccessmodel extends Model
{
    //

    public $primaryKey = 'useraccess_id';
    protected $table = "useraccess_master";
    protected $fillable = [
        'email_id', 'mobileno','status','user_id','user_name',
    ];
}
