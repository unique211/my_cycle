<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membertypemodel extends Model
{
    //

    public $primaryKey = 'membertype_id';
    protected $table = "membertype_master";
    protected $fillable = [
        'member_type', 'status', 'user_id',
    ];
}
