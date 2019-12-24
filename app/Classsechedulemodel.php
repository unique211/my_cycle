<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classsechedulemodel extends Model
{
    //
    public $primaryKey = 'classsechedule_id';
    protected $table = "class_sechedule_master";
    protected $fillable = [
        'classsechedule_name','class_schedule', 'instructor','max_vacancy','class_duration','room_id','min_cancelation','min_booking','status','user_id','endtime',
    ];
}
