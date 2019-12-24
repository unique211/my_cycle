<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Instructormastermodel;
use App\Loginmastermodel;
use App\Logmodel;
use Session;

class InstructorController extends Controller
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
            return view('instructor',$data);
        }
    }

    public function instrucoruploadimg(Request $request)
    {


        $extension = $request->file('file')->getClientOriginalExtension();

        $dir = 'uploads/';
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // echo  dd($filename);
        $request->file('file')->move($dir, $filename);


        return $filename;
    }
    public function getintructorright()
    {
        $profile = DB::table('profile_master')->where('profile_type', 'Instructor')->get();
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
    public function checkuserid($userid)
    {
        $profile = DB::table('login_master')->where('user_id', $userid)->get();
        $count = count($profile);
        return Response::json($count);
    }
    public function store(Request $request)
    {
        $ID = $request->save_update;
        $user_id = Session::get('login_id');
        if ($ID > 0) {
            $data = DB::table('instuctor_master')->where('instructor_name', $request->name)->where('instructorid', '!=', $ID)->get();
            $count = count($data);
            if ($count > 0) {
                return response()->json('100');
            } else {
                $data = DB::table('login_master')->where('user_id', $request->user_id)->where('ref_id', '!=', $ID)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('101');
                } else {
                    $customer   =   Instructormastermodel::updateOrCreate(
                        ['instructorid' => $ID],
                        [
                            'instructor_id'        =>  $request->ins_id,
                            'instructor_name'        =>  $request->name,
                            'instructor_telno'        =>  $request->tel_no,
                            'instructor_img'        =>  $request->imghidden,
                            'status'        => 1,
                            'user_id'        => $user_id,
                        ]

                    );
                    $ref_id = $customer->instructorid;

                    $urdata = $request->studejsonObj;
                    $u_rights = "";
                    $cnt = 0;




                    foreach ($urdata as $value) {


                        $u_rights = array(
                            'instructor_id' => $ref_id,
                            'menuid' => $value["menuid"],
                            'submenuid' => $value["submenu"],
                            'userright' => $value["permission"],
                        );
                        $result =  DB::table('instructor_right')
                            ->where('menuid', $value["menuid"])
                            ->where('submenuid', $value["submenu"])
                            ->where('instructor_id', $ref_id)
                            ->get();

                        $count = count($result);
                        if ($count > 0) { } else {
                            $result =  DB::table('instructor_right')
                                ->Insert($u_rights);
                        }


                        $cnt++;
                    }
                    $str = $request->password;

                    // $role =    $request->user_type;
                    $result =  DB::table('profile_master')
                        ->where('profile_type', 'Instructor')
                        ->first();
                    $role =    $result->profile_id;
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

                        $Logmodel->module_name = 'Instructor  Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $ID;
                        $Logmodel->table_name = 'instuctor_master';
                        $Logmodel->user_id = $user_id;

                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Instructor Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $ref_id;
                        $Logmodel->table_name = 'instuctor_master';
                        $Logmodel->user_id = $user_id;

                        $Logmodel->save();
                    }
                    return Response::json($ref_id);
                }
            }
        } else {
            $data = DB::table('instuctor_master')->where('instructor_name', $request->name)->get();
            $count = count($data);
            if ($count > 0) {
                return response()->json('100');
            } else {
                $data = DB::table('login_master')->where('user_id', $request->user_id)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('101');
                } else {
                    $customer   =   Instructormastermodel::updateOrCreate(
                        ['instructorid' => $ID],
                        [
                            'instructor_id'        =>  $request->ins_id,
                            'instructor_name'        =>  $request->name,
                            'instructor_telno'        =>  $request->tel_no,
                            'instructor_img'        =>  $request->imghidden,
                            'status'        => 1,
                            'user_id'        => $user_id,
                        ]

                    );
                    $ref_id = $customer->instructorid;

                    $urdata = $request->studejsonObj;
                    $u_rights = "";
                    $cnt = 0;




                    foreach ($urdata as $value) {


                        $u_rights = array(
                            'instructor_id' => $ref_id,
                            'menuid' => $value["menuid"],
                            'submenuid' => $value["submenu"],
                            'userright' => $value["permission"],
                        );
                        $result =  DB::table('instructor_right')
                            ->where('menuid', $value["menuid"])
                            ->where('submenuid', $value["submenu"])
                            ->where('instructor_id', $ref_id)
                            ->get();

                        $count = count($result);
                        if ($count > 0) { } else {
                            $result =  DB::table('instructor_right')
                                ->Insert($u_rights);
                        }


                        $cnt++;
                    }
                    $str = $request->password;

                    $result =  DB::table('profile_master')
                        ->where('profile_type', 'Instructor')
                        ->first();
                    $role =    $result->profile_id;


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

                        $Logmodel->module_name = 'Instructor  Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $ID;
                        $Logmodel->table_name = 'profile_master';
                        $Logmodel->user_id = $user_id;

                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Instructor Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $ref_id;
                        $Logmodel->table_name = 'profile_master';
                        $Logmodel->user_id = $user_id;

                        $Logmodel->save();
                    }
                    return Response::json($ref_id);
                }
            }
        }
    }

    public function getall_instructor()
    {
        $getresult = array();
        $result =  DB::table('instuctor_master')

            ->get();

        $count = count($result);

        if ($count > 0) {
            foreach ($result as $data) {
                $instructorid = $data->instructorid;
                $instructor_id = $data->instructor_id;
                $instructor_name = $data->instructor_name;
                $instructor_telno = $data->instructor_telno;
                $instructor_img = $data->instructor_img;
                $status = $data->status;
                $userid = "";
                if ($instructorid > 0) {

                    $result_role =  DB::table('profile_master')
                        ->where('profile_type', 'Instructor')
                        ->first();
                    $role =    $result_role->profile_id;

                    $result1 =  DB::table('login_master')
                        ->where('ref_id', $instructorid)
                        ->where('role', $role)
                        ->get();
                    foreach ($result1 as $data1) {
                        $userid = $data1->user_id;
                    }
                }
                $getresult[] = array(
                    'instructorid' => $instructorid,
                    'instructor_id' => $instructor_id,
                    'instructor_name' => $instructor_name,
                    'instructor_telno' => $instructor_telno,
                    'instructor_img' => $instructor_img,
                    'userid' => $userid,

                );
            }
        }

        return Response::json($getresult);
    }

    public function geteditintructorright($id)
    {
        $result =  DB::table('instructor_right')
            ->where('instructor_id', $id)
            ->get();
        return Response::json($result);
    }
    public function deleteinstructorright(Request $request)
    {
        // $result =  DB::table('instructor_right')
        //             ->where('instructor_id',$id)
        //             ->get();
        $result =  DB::table('instructor_right')->where('instructor_id', $request->save_update)->delete();
        // return Response::json($customer);
        return Response::json($result);
    }
    public function checkinstuctorname($name)
    {
        $profile = DB::table('instuctor_master')->where('instructor_name', $name)->get();
        $count = count($profile);
        return Response::json($count);
    }
    public function deleteallinfoin($id)
    {
        $user_id = Session::get('login_id');
        // DB::update('update login_master set status = ? where ref_id = ? And  role =? ',[0,$id,"Instructor"]);
        DB::table('instructor_right')->where('instucuteright_id', $id)->delete();
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Instructor  Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'instuctor_master';
        $Logmodel->user_id = $user_id;

        $Logmodel->save();

        DB::table('login_master')->where('ref_id', $id)->where('role', 'Instructor')->delete();
        $result =  DB::table('instuctor_master')->where('instructorid', $id)->delete();
        return Response::json($result);
    }
}
