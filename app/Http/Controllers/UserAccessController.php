<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Useraccessmodel;
use App\Loginmastermodel;
use App\Logmodel;
use Session;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('user_access');
        }
    }
    public function getallprofileright($usertype)
    {
        $profile = DB::table('profile_master')->where('profile_id', $usertype)->get();
        $count = count($profile);
        if ($count > 0) {
            foreach ($profile as $profiledata) {
                $id = $profiledata->profile_id;
                if ($id > 0) {
                    $result =  DB::table('profile_details')
                        ->where('profileid', $id)
                        ->get();
                    return Response::json($result);
                }
            }
        }
    }

    public function get_all_profile_data()
    {
        $result =  DB::table('profile_master')

            ->whereNOTIn('profile_type', function ($query) {
                $query->select('profile_type')->from('profile_master')->where('profile_type', 'Instructor');
            })
            ->get();
        return Response::json($result);
    }

    public function checkemailaddress($userid)
    {
        $profile = DB::table('useraccess_master')->where('email_id', $userid)->get();
        $count = count($profile);
        return Response::json($count);
    }
    public function checkusername($name)
    {
        $profile = DB::table('useraccess_master')->where('user_name', $name)->get();
        $count = count($profile);
        return Response::json($count);
    }
    public function store(Request $request)
    {
        $ID = $request->save_update;
        $user_id = $request->session()->get('login_id');

        if ($ID > 0) {
            $data = DB::table('useraccess_master')->where('user_name', $request->name)->where('useraccess_id', '!=', $ID)->get();
            $count = count($data);
            if ($count > 0) {
                return response()->json('100');
            } else {
                $data = DB::table('login_master')->where('user_id', $request->email)->where('ref_id', '!=', $ID)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('101');
                } else {
                    $customer   =   Useraccessmodel::updateOrCreate(

                        ['useraccess_id' => $ID],
                        [
                            'user_name'        =>  $request->name,
                            'email_id'        =>  $request->email,
                            'mobileno'        =>  $request->phone,
                            'status'        => 1,
                            'user_id'        => $user_id,
                        ]

                    );
                    $ref_id = $customer->useraccess_id;

                    $urdata = $request->studejsonObj;
                    $u_rights = "";
                    $cnt = 0;




                    foreach ($urdata as $value) {


                        $u_rights = array(
                            'useraccess_id' => $ref_id,
                            'menuid' => $value["menuid"],
                            'submenuid' => $value["submenu"],
                            'userright' => $value["permission"],
                        );
                        $result =  DB::table('user_right_details')
                            ->where('menuid', $value["menuid"])
                            ->where('submenuid', $value["submenu"])
                            ->where('useraccess_id', $ref_id)
                            ->get();

                        $count = count($result);
                        if ($count > 0) { } else {
                            $result =  DB::table('user_right_details')
                                ->Insert($u_rights);
                        }


                        $cnt++;
                    }
                    $str = $request->password;

                    $role =    $request->user_type;


                    if ($str != "") {
                        $md5 = md5($str);

                        $password = base64_encode($md5);
                        $customer2   =   Loginmastermodel::updateOrCreate(
                            ['ref_id' => $ref_id, 'role' => $role],
                            [

                                'user_id'        =>   $request->user_id,
                                'password'        =>   $password,
                                'role'        =>    $role,

                            ]

                        );
                    } else {
                        //   dd($role."password = ".$str);
                        // $customer2   =   Loginmastermodel::update(
                        //     ['ref_id' => $ref_id, 'role' => $role],
                        //     [
                        //         'user_id'        =>   $request->user_id,
                        //         'role'        =>    $role,
                        //     ]

                        // );

                        $where = array('ref_id' => $ref_id, 'role' => $request->user_type_hidden);
                        $set = array('user_id' => $request->user_id, 'role' => $role);
                        $customer2 = DB::table('login_master')
                            ->where($where)
                            ->update($set);
                    }

                    if ($ID > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'User Access  Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $ID;
                        $Logmodel->table_name = 'useraccess_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'User Access Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $ref_id;
                        $Logmodel->table_name = 'useraccess_master';
                        $Logmodel->user_id = $user_id;

                        // $Logmodel->table_name = 'package_master';
                        $Logmodel->save();
                    }
                    return Response::json($ref_id);
                }
            }
        } else {
            $data = DB::table('useraccess_master')->where('user_name', $request->name)->get();
            $count = count($data);
            if ($count > 0) {
                return response()->json('100');
            } else {
                $data = DB::table('login_master')->where('user_id', $request->email)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('101');
                } else {
                    $customer   =   Useraccessmodel::updateOrCreate(
                        ['useraccess_id' => $ID],
                        [
                            'user_name'        =>  $request->name,
                            'email_id'        =>  $request->email,
                            'mobileno'        =>  $request->phone,
                            'status'        => 1,
                            'user_id'        => $user_id,
                        ]

                    );
                    $ref_id = $customer->useraccess_id;

                    $urdata = $request->studejsonObj;
                    $u_rights = "";
                    $cnt = 0;




                    foreach ($urdata as $value) {


                        $u_rights = array(
                            'useraccess_id' => $ref_id,
                            'menuid' => $value["menuid"],
                            'submenuid' => $value["submenu"],
                            'userright' => $value["permission"],
                        );
                        $result =  DB::table('user_right_details')
                            ->where('menuid', $value["menuid"])
                            ->where('submenuid', $value["submenu"])
                            ->where('useraccess_id', $ref_id)
                            ->get();

                        $count = count($result);
                        if ($count > 0) { } else {
                            $result =  DB::table('user_right_details')
                                ->Insert($u_rights);
                        }


                        $cnt++;
                    }
                    $str = $request->password;

                    $role =  $request->user_type;
                    if ($str != "") {
                        $md5 = md5($str);
                        $password = base64_encode($md5);
                        $customer2   =   Loginmastermodel::updateOrCreate(
                            ['ref_id' => $ref_id, 'role' => $role],
                            [

                                'user_id'        =>   $request->user_id,
                                'password'        =>   $password,
                                'role'        =>    $role,

                            ]

                        );
                    } else {
                        $customer2   =   Loginmastermodel::updateOrCreate(
                            ['ref_id' => $ref_id, 'role' => $role],
                            [
                                'user_id'        =>   $request->user_id,
                                'role'        =>    $role,
                            ]

                        );
                    }

                    if ($ID > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'User Access';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $ID;
                        $Logmodel->table_name = 'useraccess_master';
                        $Logmodel->user_id = $user_id;
                        // $Logmodel->table_name = 'package_master';
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'User Access';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $ref_id;
                        $Logmodel->table_name = 'useraccess_master';
                        $Logmodel->user_id = $user_id;
                        // $Logmodel->table_name = 'package_master';
                        $Logmodel->save();
                    }
                    return Response::json($ref_id);
                }
            }
        }
    }
    public function getall_useraccess()
    {
        $getresult = array();
        $result =  DB::table('useraccess_master')
            ->select('useraccess_master.*')
            ->orderBy('useraccess_master.useraccess_id', 'DESC')
            // ->join('login_master', 'login_master.ref_id', '=', 'useraccess_master.useraccess_id')
            // ->join('profile_master', 'profile_master.profile_id', '=', 'login_master.role')
            // ->where('profile_master.profile_type', '!=', 'Instructor')
            ->get();

        $count = count($result);

        if ($count > 0) {
            foreach ($result as $data) {
                $result1 =  DB::table('login_master')
                    ->select('login_master.*', 'profile_master.profile_type', 'useraccess_master.*')
                    ->join('profile_master', 'profile_master.profile_id', '=', 'login_master.role')
                    ->join('useraccess_master', 'useraccess_master.useraccess_id', '=', 'login_master.ref_id')
                    ->where('login_master.ref_id', $data->useraccess_id)
                    ->where('profile_master.profile_type', '!=', 'Instructor')
                    ->orderBy('login_master.login_id', 'DESC')
                    //->where('role','!=',3)
                    ->get();
                $cnt2 = count($result1);
                if ($cnt2 > 0) {

                    $userid = "";
                    $role = "";
                    $profile_type = "";
                    foreach ($result1 as $data1) {

                        $useraccess_id = $data1->useraccess_id;
                        $user_name = $data1->user_name;
                        $email_id = $data1->email_id;
                        $mobileno = $data1->mobileno;


                        $status = $data1->status;

                        $userid = $data1->user_id;
                        $role = $data1->role;
                        $profile_type = $data1->profile_type;


                        $is_instructor =  DB::table('profile_master')
                            ->where('profile_type', 'Instructor')
                            ->first();
                        $instructor = $is_instructor->profile_id;

                        $data = DB::table('login_master')
                            ->select('login_master.*')
                            ->where('login_master.login_id', $userid)
                            ->first();
                        $ref_id = $data->ref_id;

                        $userid_name = "";
                        if ($data->role == $instructor) {
                            $data1 = DB::table('instuctor_master')
                                ->select('instuctor_master.*')
                                ->where('instuctor_master.instructorid', $ref_id)
                                ->first();
                            $userid_name = $data1->instructor_name;
                        } else {
                            $data1 = DB::table('useraccess_master')
                                ->select('useraccess_master.*')
                                ->where('useraccess_master.useraccess_id', $ref_id)
                                ->first();
                            $userid_name = $data1->user_name;
                        }
                    }

                    $getresult[] = array(
                        'useraccess_id' => $useraccess_id,
                        'user_name' => $user_name,
                        'email_id' => $email_id,
                        'mobileno' => $mobileno,
                        'role' => $role,
                        'profile_type' => $profile_type,
                        'userid' => $userid_name,
                        'status' => $status,

                    );
                }
            }
        }

        return Response::json($getresult);
    }

    public function getedituserright($id)
    {
        $result =  DB::table('user_right_details')
            ->where('useraccess_id', $id)
            ->get();
        return Response::json($result);
    }
    public function useracessrightdel(Request $request)
    {
        $result =  DB::table('user_right_details')->where('useraccess_id', $request->save_update)->delete();
        return Response::json($result);
    }
    public function deleteuseraccess($id)
    {
        $user_id = Session::get('login_id');
        // DB::table('login_master')->where('ref_id', $id)->where('role',$id)delete();
        // DB::update('update login_master set status = ? where ref_id = ? And  role !=? ',[0,$id,"Instructor"]);

        DB::table('login_master')->where('ref_id', $id)->where('role', '!=', 'Instructor')->delete();

        DB::table('user_right_details')->where('useraccess_id', $id)->delete();
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'User Access  Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'useraccess_master';
        $Logmodel->user_id = $user_id;
        // $Logmodel->table_name = 'package_master';
        $Logmodel->save();


        $result =  DB::table('useraccess_master')->where('useraccess_id', $id)->delete();
        return Response::json($result);
    }
}
