<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classcategorymodel extends Model
{
    //
    public $primaryKey = 'classcategory_id';
    protected $table = "classcategory_master";
    protected $fillable = [
        'classcategory_name', 'category_description','status','user_id'
    ];
}
