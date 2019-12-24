<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitesettingmodel extends Model
{
    //
    public $primaryKey = 'sitesetting_id';
    protected $table = "sitesetting_master";
    protected $fillable = [
       'site_name','site_logo','site_email','site_about_details1','site_about_details2','site_contact_detalis1','site_contact_detalis2','telephone_no','website','facebook','instagram','firebase','map','user_id','status'
    ];
}
