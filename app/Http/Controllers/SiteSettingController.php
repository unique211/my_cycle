<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitesettingmodel;

use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;
class SiteSettingController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            $ref_id = Session::get('userid');
            $sidebar = DB::table('useraccess_master')
                ->select('useraccess_master.*', 'user_right_details.menuid', 'user_right_details.submenuid')
                ->join('user_right_details', 'user_right_details.useraccess_id', '=', 'useraccess_master.useraccess_id')
                ->where('useraccess_master.email_id', $ref_id)

                ->get();
            $count = count($sidebar);
            if ($count > 0) {
                $data['sidebar'] = $sidebar;
            } else {
                $data['sidebar'] = null;
            }
            return view('site_setting',$data);
        }

    }
    public function store(Request $request)//For insert or Update Record Of Package Master --
    {

        $user_id = Session::get('login_id');
        $packege_id = $request->save_update;

        $input = $request->all();


        $validator = Validator::make($input, [
            'site_name' => 'required',
            'uploadimg_hidden' => 'required',
            'email'=>'required',
            'tel_no'=>'required',
            'website'=>'required',
            'facebook'=>'required',
            'instagram'=>'required',
            'firebase'=>'required',
           // 'map'=>'required',

            ]);

            if($validator->fails()){

                return response()->json('less Arguments OR Package Name Already Exists ');
            }else{
                if($packege_id >0){
                    $data= DB::table('sitesetting_master')->where('site_name',$request->site_name)->where('sitesetting_id','!=',$packege_id)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $data1= DB::table('sitesetting_master')->where('site_email',$request->email)->where('sitesetting_id','!=',$packege_id)->get();
                        $count1=count($data1);
                        if($count >0){
                            return response()->json('101');
                        }else{
                            $package   =   Sitesettingmodel::updateOrCreate(
                                ['sitesetting_id' => $packege_id],
                                [
                                    'site_name'       =>   $request->site_name,
                                    'site_logo'        =>   $request->uploadimg_hidden,
                                    'site_email'        =>   $request->email,
                                    'site_about_details1' =>   $request->about_us,
                                    'site_about_details2'  =>   $request->about_us_c,
                                    'site_contact_detalis1'        =>   $request->contact_us,
                                    'site_contact_detalis2'        =>   $request->contact_us_c,

                                    'telephone_no'        =>   $request->tel_no,
                                    'website'        =>   $request->website,
                                    'facebook'=>$request->facebook,
                                    'instagram'=>$request->instagram,
                                    'firebase'=>$request->firebase,
                                    'map'=>$request->map,
                                    'user_id'=>$user_id,


                                ]

                            );


                                $Logmodel = new Logmodel;

                                $Logmodel->module_name ='Site Setting Module' ;
                                $Logmodel->operation_name ='Edit';
                                $Logmodel->reference_id = $packege_id;
                                $Logmodel->table_name = 'sitesetting_master';
                                $Logmodel->user_id = $user_id;
                                $Logmodel->save();
                                return Response::json($package);
                    }
                }
            }else{
                $data= DB::table('sitesetting_master')->where('site_name',$request->site_name)->get();
                $count=count($data);
                if($count >0){
                    return response()->json('100');
                }else{
                    $data1= DB::table('sitesetting_master')->where('site_email',$request->email)->get();
                    $count1=count($data1);
                    if($count >0){
                        return response()->json('101');
                    }else{
                        $package   =   Sitesettingmodel::updateOrCreate(
                            ['sitesetting_id' => $packege_id],
                            [
                                'site_name'       =>   $request->site_name,
                                'site_logo'        =>   $request->uploadimg_hidden,
                                'site_email'        =>   $request->email,
                                'site_about_details1' =>   $request->about_us,
                                'site_about_details2'  =>   $request->about_us_c,
                                'site_contact_detalis1'        =>   $request->contact_us,
                                'site_contact_detalis2'        =>   $request->contact_us_c,

                                'telephone_no'        =>   $request->tel_no,
                                'website'        =>   $request->website,
                                'facebook'=>$request->facebook,
                                'instagram'=>$request->instagram,
                                'firebase'=>$request->firebase,
                                'map'=>$request->map,
                                'user_id'=>$user_id,


                            ]

                        );


                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Site Setting Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $package->sitesetting_id;
                            $Logmodel->table_name = 'sitesetting_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                            return Response::json($package);
                }
            }
            }
        }
    }
    public function getallsitesettinginfo(){

        $sitesetting= DB::table('sitesetting_master')->get();

        return Response::json($sitesetting);
    }
    public function deletesitesetting($id){
 $Logmodel = new Logmodel;
 $user_id = Session::get('login_id');
    $Logmodel->module_name ='Site Setting Module' ;
    $Logmodel->operation_name ='Delete';
    $Logmodel->reference_id = $id;
    $Logmodel->table_name = 'sitesetting_master';
    $Logmodel->user_id = $user_id;
    $Logmodel->save();
    $customer = Sitesettingmodel::where('sitesetting_id', $id)->delete();
    return response()->json( $customer);
    }

    public function get_site_settings_api(){

        $data= DB::table('sitesetting_master')->get();
        $result = array();


        foreach ($data as $val) {


            $result[] = array(
                'sitesetting_id' => $val->sitesetting_id,
                'site_name' => $val->site_name,
                'site_logo' =>  $val->site_logo,
                'site_email' =>  $val->site_email,
                'site_about_details_english' =>  $val->site_about_details1,
                'site_about_details_chinese' =>  $val->site_about_details2,
                'site_contact_detalis_english' =>  $val->site_contact_detalis1,
                'site_contact_detalis_chinese' =>  $val->site_contact_detalis2,
                'telephone_no' =>  $val->telephone_no,
                'website' =>  $val->website,
                'facebook' =>  $val->facebook,
                'instagram' =>  $val->instagram,
                'firebase' =>  $val->firebase,
                'map' =>  $val->map,




            );
        }

        return Response::json($result);
    }
}
