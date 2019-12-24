<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Redirect, Response;
use Session;
class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('userid')) {
            $request->session()->flush();
        }

        return view('login');
    }

    public function check_login(Request $request)
    {


        //return view('user_manage');
        $user_id = $request->user_id;


        $str = $request->password;
        $md5 = md5($str);
        $password = base64_encode($md5);
        $msg = 0;



        $user = DB::table('login_master')
            ->select('login_master.*')
            ->where('user_id', $user_id)
            ->where('password', $password)
            ->get();

        $cnt = count($user);



        if ($cnt > 0) {
            $get_password = "";
            $get_user_id = "";
            $get_role = "";
            $get_id = "";
            $ref_id = "";


            foreach ($user as $user1) {
                $get_password =  $user1->password;
                $get_user_id =  $user1->user_id;
                $get_role =  $user1->role;
                $get_id =  $user1->login_id;
                $ref_id =  $user1->ref_id;
            }


            if (($get_user_id == $user_id) && ($get_password == $password)) {
                $msg = 1;

                $role_id = DB::table('profile_master')
                    ->select('profile_master.*')
                    ->where('profile_id', $get_role)
                    ->first();

                $role = $role_id->profile_type;
                $user_name="";

                if($role=="Instructor"){
                    $user_nm=DB::table('instuctor_master')
                    ->select('instuctor_master.*')
                    ->where('instructorid', $ref_id)
                    ->first();
                    $user_name=$user_nm->instructor_name;
                }else{
                    $user_nm=DB::table('useraccess_master')
                    ->select('useraccess_master.*')
                    ->where('useraccess_id', $ref_id)
                    ->first();
                    $user_name=$user_nm->user_name;
                }

                $request->session()->put('userid',  $user_id);
                $request->session()->put('role',  $role);
                $request->session()->put('login_id',  $get_id);
                $request->session()->put('user_name',  $user_name);
            }
        }

        return $msg;
        // //   return Response::json($msg);
    }
}
