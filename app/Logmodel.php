<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logmodel extends Model
{
    //
    protected $table = "log_master";
    protected $fillable = [
        'module_name', 'operation_name', 'reference_id','table_name','user_id'
    ];
}
