<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallarymodel extends Model
{
    //
    public $primaryKey = 'gallary_id';
    protected $table = "gallary_master";
    protected $fillable = [
        'uploadimg','nooflike', 'allowshare','status','user_id','description','is_video'
    ];


}
