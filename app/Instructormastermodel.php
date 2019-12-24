<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructormastermodel extends Model
{
    //
    public $primaryKey = 'instructorid';
    protected $table = "instuctor_master";
    protected $fillable = [
        'instructor_id','instructor_name', 'instructor_telno','instructor_img','status','user_id',
    ];
}
