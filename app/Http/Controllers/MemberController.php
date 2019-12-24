<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Membermodel;

use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('member');
        }
    }

    public function getdropdwnallpackage()
    {
        $data = DB::table('package_master')->where('status', 1)->get();
        return response()->json($data);
    }
    public function getpackagepoint(Request $request)
    {

        $data = DB::table('package_master')->where('packege_id', $request->package)->get();
        return response()->json($data);
    }
    public function store(Request $request) //For insert or Update Record Of Package Master --
    {


        $user_id = Session::get('login_id');
        $ID = $request->save_update;
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'name' => 'required',
            'uploadimg_hidden' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json('less Arguments');
        } else {


            $customer   =   Membermodel::updateOrCreate(
                ['member_id' => $ID],
                [
                    'membername'        =>  $request->name,
                    'icno'        =>  $request->ic_number,
                    'dob'        =>  $request->dob,
                    'address'        =>  $request->address,
                    'email'        =>  $request->email,
                    'currentpackage'        =>  $request->package,
                    'membertype'        =>  $request->member_type,
                    'dateofexpire'        =>  $request->doe,
                    'balancepoint'        =>  $request->bal_point,
                    'image_url'       =>   $request->uploadimg_hidden,
                    'user_id'        => $user_id,
                ]

            );
            $ref_id = $customer->member_id;

            $urdata = $request->studejsonObj;
            $u_rights = "";
            $cnt = 0;



            foreach ($urdata as $value) {


                $u_rights = array(
                    'member_id' => $ref_id,
                    'name' => $value["relname"],
                    'userid' => $value["reluserid"],
                    'relation' => $value["relation"],
                    'password' => $value["password"],
                );


                $result =  DB::table('link_relation_ship')
                    ->where('userid', $value["reluserid"])
                    ->get();

                $count = count($result);
                if ($count > 0) { } else {
                    $result =  DB::table('link_relation_ship')
                        ->Insert($u_rights);
                }
            }

            if ($ID > 0) {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Members Module';
                $Logmodel->operation_name = 'Edit';
                $Logmodel->reference_id = $ID;
                $Logmodel->table_name = 'member_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            } else {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Members Module';
                $Logmodel->operation_name = 'Insert';
                $Logmodel->reference_id = $ref_id;
                $Logmodel->table_name = 'member_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            }
            return Response::json($ref_id);
        }
    }
    public function deletemembers(Request $request)
    {
        $id = $request->save_update;

        $customer =  DB::table('link_relation_ship')->where('member_id', $id)->delete();
        return Response::json($customer);
    }
    public function uploadimg(Request $request)
    {


        $extension = $request->file('file')->getClientOriginalExtension();

        $dir = 'gallaryimg/member/';
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // echo  dd($filename);
        $request->file('file')->move($dir, $filename);


        return $filename;
    }
    public function getallmember()
    {
        $result = array();
        $customer =  DB::table('member_master')->get();
        $count = count($customer);

        if ($count > 0) {
            foreach ($customer as $data) {
                $member_id = $data->member_id;
                $membername = $data->membername;
                $icno = $data->icno;
                $dob = $data->dob;
                $address = $data->address;
                $email = $data->email;
                $currentpackage = $data->currentpackage;
                $membertype = $data->membertype;
                $dateofexpire = $data->dateofexpire;
                $balancepoint = $data->balancepoint;
                $image_url = $data->image_url;
                $packagename = "";
                $user_id = "";
                $password = "";
                $customer1 =  DB::table('link_relation_ship')->where('member_id', $member_id)->get();
                $count1 = count($customer1);

                $customer3 =  DB::table('link_relation_ship')->where('member_id', $member_id)->where('relation', 'Main Member')->get();


                foreach ($customer3 as $linkdata) {
                    $user_id = $linkdata->userid;
                    $password = $linkdata->password;
                }

                $customer2 =  DB::table('package_master')->where('packege_id', $currentpackage)->get();
                $count2 = count($customer2);

                foreach ($customer2 as $packagedata) {
                    $packagename = $packagedata->package_name;
                }

                $result[] = array(
                    'member_id' => $member_id,
                    'membername' => $membername,
                    'icno' => $icno,
                    'dob' => $dob,
                    'address' => $address,
                    'email' => $email,
                    'currentpackage' => $currentpackage,
                    'membertype' => $membertype,
                    'dateofexpire' => $dateofexpire,
                    'balancepoint' => $balancepoint,
                    'membercount' => $count1,
                    'packagename' => $packagename,
                    'image_url' => $image_url,
                    'user_id' => $user_id,
                    'password' => $password,


                );
            }
        }
        return Response::json($result);
    }
    public function getgroupwiseinfo(Request $request)
    {
        $customer =  DB::table('link_relation_ship')->where('member_id', $request->id)->where('relation', '!=', 'Main Member')->get();
        return Response::json($customer);
    }
    public function deletememberinfo($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Members Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'member_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        DB::table('link_relation_ship')->where('member_id', $id)->delete();
        $result =  DB::table('member_master')->where('member_id', $id)->delete();
        return Response::json($result);
    }
    public function checkuseridexist($user_id)
    {
        $data = DB::table('link_relation_ship')->where('userid', $user_id)->get();
        $count = count($data);
        return Response::json($count);
    }
    public function checkedituseridexist($user_id, $id)
    {
        $data = DB::table('link_relation_ship')->where('userid', $user_id)->where('member_id', '!=', $id)->get();
        $count = count($data);
        return Response::json($count);
    }
    public function pointusage($id)
    {


        $result = array();

        $data1 =  DB::table('link_relation_ship')
            ->where('member_id', $id)
            ->get();

        $data2 = "";



        foreach ($data1 as $val1) {
            $link_id = $val1->linkrelid;
            // $result[] = array('link'=>$link_id);


            $data2 = DB::table('booking_table')
                ->select('booking_table.*', 'class_sechedule_master.classsechedule_name', 'class_sechedule_master.instructor', 'class_master.class_name as classname', 'instuctor_master.instructor_name')
                ->join('class_sechedule_master', 'class_sechedule_master.classsechedule_id', '=', 'booking_table.class_schedule_id')
                ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                ->where('booking_table.link_id', $link_id)
                ->where('booking_table.is_cancelled', 1)
                ->where('booking_table.rating_points', -1)
                ->get();



            foreach ($data2 as $val2) {





                $result[] = array(
                    'id' => $val2->booking_id,
                    'user_id' => $val1->userid,
                    'date_time' => $val2->date_time,
                    'class_name' => $val2->classname,
                    'point_use' => $val2->points,
                    'Instructor' => $val2->instructor_name,
                );
            }




        }
         //dd($result);
        return Response::json($result);
    }
}
