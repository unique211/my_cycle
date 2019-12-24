<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profiemastermodel;


use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;
class ProfileManagerController extends Controller
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
            return view('profile_manager',$data);
        }

    }
    public function getallmenu(){
        $result=array();
        $data = DB::table('menu_master')
        ->select('menu_master.*')
        ->get();
        foreach($data as $value){
            $menuid=$value->menu_id;
            $menuname=$value->menuname;
            $submenu=array();
            if($menuid >0){
                $subdata = DB::table('submenu_master')
                ->select('submenu_master.*')
                ->where('menu_id',$menuid)
                ->get();
                $count=count($subdata);
                if($count >0){
                    foreach($subdata as $getsubmenu){
                     $submenu_id=  $getsubmenu->submenu_id;
                     $menu_id=  $getsubmenu->menu_id;
                     $submenuname=  $getsubmenu->submenuname;

                     $submenu[]=array(
                         'submenu_id'=>$submenu_id,
                         'menu_id'=>$menu_id,
                        'submenuname'=>$submenuname,
                     );
                    }
                }

            }
            $result[]=array(
                'menuid'=>$menuid,
                'menu_name'=>$menuname,
                'submenudata'=>$submenu,
            );

        }

        return Response::json($result);
    }
    public function store(Request $request)
    {
        $ID = $request->save_update;
        $user_id = Session::get('login_id');
        $customer   =   Profiemastermodel::updateOrCreate(
            ['profile_id' => $ID],
            [
                'profile_type'        =>  $request->profiletype,
                'user_id'        => $user_id,
            ]

        );
        $ref_id = $customer->profile_id;

        $urdata = $request->studejsonObj;
        $u_rights = "";
        $cnt = 0;



        foreach ($urdata as $value) {


            $u_rights = array(
                'profileid' => $ref_id,
                'menuid' => $value["menuid"],
                'submenuid' =>$value["submenu"],
                'userright' =>$value["permission"] ,
            );
            $result =  DB::table('profile_details')
            ->where('menuid',$value["menuid"])
            ->where('submenuid',$value["submenu"])
            ->where('profileid',$ref_id)
            ->get();

            $count=count($result);
            if($count >0){

            }else{
                $result =  DB::table('profile_details')
                ->Insert($u_rights);
            }


            $cnt++;
        }

        if( $ID >0){
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Profile  Module' ;
            $Logmodel->operation_name ='Edit';
            $Logmodel->reference_id = $ID;
            $Logmodel->table_name = 'profile_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();

        }else{
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Profile Module' ;
            $Logmodel->operation_name ='Insert';
            $Logmodel->reference_id = $customer->profile_id;
            $Logmodel->table_name = 'profile_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
        }
        return Response::json($ref_id);


    }
    public function get_all_profile() {
        $result =  DB::table('profile_master')
        ->get();
        return Response::json($result);
    }
    public function getallmenuright($id){

        $result =  DB::table('profile_details')
        ->where('profileid',$id)
        ->get();
        return Response::json($result);
    }
    public function deleteuserright(Request $request){
      $id=$request->save_update;

      $customer =  DB::table('profile_details')->where('profileid', $id)->delete();
      return Response::json($customer);
    }
    public function deleteprofile($id){

        $user_id = Session::get('login_id');
        DB::table('profile_details')->where('profileid', $id)->delete();

        $customer =  DB::table('profile_master')->where('profile_id', $id)->delete();

        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Profile Master Module' ;
        $Logmodel->operation_name ='Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'profile_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();


        return Response::json($customer);

    }
}
