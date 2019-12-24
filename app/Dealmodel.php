<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealmodel extends Model
{
    //
    public $primaryKey = 'deal_id';
    protected $table = "deal_master";
    protected $fillable = [
        'deal_title','deal_title', 'upload_img','start_date','end_date','user_id','is_video'
    ];
}
