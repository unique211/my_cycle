<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roommastermodel extends Model
{
    //
    public $primaryKey = 'rooom_id';
    protected $table = "room_master";
    protected $fillable = [
        'room', 'user_id','status'
    ];
}
