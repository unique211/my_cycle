<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use App\Logmodel;
use App\Classsechedulemodel;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;

class ClassScheduleController extends Controller
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
            return view('class_schedule',$data);
        }
    }
    //getall class
    public function getdropallclass()
    {
        $data = DB::table('class_master')->where('status', 1)->get();
        return response()->json($data);
    }

    //get all room

    public function getdropallroom()
    {
        $data = DB::table('room_master')->where('status', 1)->get();
        return response()->json($data);
    }

    public function store(Request $request) //For insert or Update Record Of Room Master --
    {

        $user_id = Session::get('login_id');
        $catid = $request->save_update;

        $input = $request->all();
        if ($catid == "") {
            $validator = Validator::make($input, [
                'classsechedule_name' => 'required',
                'instructorid' => 'required',
                'class_schedule' => 'required',
                'max_vacancy' => 'required|numeric|gt:0',
                'class_duration' => 'required|numeric|gt:0',
                'room_id' => 'required',
                'min_cancelation' => 'required',
                'min_booking' => 'required',
                'statusinfo' => 'required',

            ]);
        } else {
            $validator = Validator::make($input, [
                'classsechedule_name' => 'required',
                'instructorid' => 'required',
                'class_schedule' => 'required',
                'max_vacancy' => 'required',
                'class_duration' => 'required',
                'room_id' => 'required',
                'min_cancelation' => 'required',
                'min_booking' => 'required',
                'statusinfo' => 'required',

            ]);
        }
        if ($validator->fails()) {

            return response()->json(['less Arguments OR Class Category Already Exists']);
        } else {
            $from1 = strtr($request->class_schedule, '/', '-');
            $class_schedule = date('Y-m-d H:i:s', strtotime($from1));

            $from2 = strtr($request->min_cancelation, '/', '-');
            $min_cancelation = date('Y-m-d H:i:s', strtotime($from2));

            $from3 = strtr($request->min_booking, '/', '-');
            $min_booking = date('Y-m-d H:i:s', strtotime($from3));

            $from4 = strtr($request->classendtime, '/', '-');
            $classendtime = date('Y-m-d H:i:s', strtotime($from4));

            if ($catid > 0) {
                $classcategory   =   Classsechedulemodel::updateOrCreate(
                    ['classsechedule_id' => $catid],
                    [
                        'classsechedule_name'       =>   $request->classsechedule_name,
                        'class_schedule' => $class_schedule,
                        'instructor' => $request->instructorid,
                        'max_vacancy' => $request->max_vacancy,
                        'class_duration' => $request->class_duration,
                        'room_id' => $request->room_id,
                        'min_cancelation' => $min_cancelation,
                        'min_booking' => $min_booking,
                        'status' => $request->statusinfo,
                        'user_id' => $user_id,
                        'endtime' => $classendtime,

                    ]

                );




                if ($catid > 0) {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Class Schedule Module';
                    $Logmodel->operation_name = 'Edit';
                    $Logmodel->reference_id = $catid;
                    $Logmodel->table_name = 'class_sechedule_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                } else {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Class Schedule Module';
                    $Logmodel->operation_name = 'Insert';
                    $Logmodel->reference_id = $classcategory->classsechedule_id;
                    $Logmodel->table_name = 'class_sechedule_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                }


                return response()->json(['data' => $classcategory]);
            } else {
                //     $data1 = DB::table('class_sechedule_master')
                //     ->select('class_sechedule_master.*')
                //      ->where('room_id',$request->room_id)
                //     ->where('instructor',$request->instructorid)
                //    // ->where('class_schedule','>=',$class_schedule)
                //    // ->where('class_schedule','<=',$classendtime)
                //    // ->whereBetween('class_schedule', [$class_schedule, $classendtime] )
                //    // ->whereBetween('endtime', [$class_schedule, $classendtime])
                //    // ->where('class_schedule' BETWEEN .$class_schedule.' AND '.$classendtime.') AND (endtime BETWEEN '.$class_schedule.' AND '.$classendtime)
                //     ->get();
                //     $count=count($data1);
                //      $flag=0;
                //     foreach($data1 as $getdata){
                //       $starttime=  $getdata->class_schedule;
                //       $endtime=  $getdata->endtime;

                //       if($starttime >= $class_schedule &&  $starttime <=$classendtime ){
                //         $flag=1;
                //         break;
                //       }
                //       if($endtime >= $class_schedule &&  $endtime <=$classendtime ){
                //         $flag=1;
                //         break;
                //       }

                //     }




                //     if($count >0){
                //         return response()->json('500');
                //     }else{
                $data2 = DB::table('class_sechedule_master')
                    ->select('class_sechedule_master.*')
                    ->where('room_id', $request->room_id)
                    ->where('instructor', $request->instructorid)
                    ->where('endtime', '>=', $class_schedule)
                    ->where('endtime', '<=', $classendtime)
                    // ->whereBetween('class_schedule', [$class_schedule, $classendtime] )
                    // ->whereBetween('endtime', [$class_schedule, $classendtime])
                    // ->where('class_schedule' BETWEEN .$class_schedule.' AND '.$classendtime.') AND (endtime BETWEEN '.$class_schedule.' AND '.$classendtime)
                    ->get();
                $count1 = count($data2);

                // dd($count1);

                $classcategory   =   Classsechedulemodel::updateOrCreate(
                    ['classsechedule_id' => $catid],
                    [
                        'classsechedule_name'       =>   $request->classsechedule_name,
                        'class_schedule' => $class_schedule,
                        'instructor' => $request->instructorid,
                        'max_vacancy' => $request->max_vacancy,
                        'class_duration' => $request->class_duration,
                        'room_id' => $request->room_id,
                        'min_cancelation' => $min_cancelation,
                        'min_booking' => $min_booking,
                        'status' => $request->statusinfo,
                        'user_id' => $user_id,
                        'endtime' => $classendtime,

                    ]

                );




                if ($catid > 0) {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Class Schedule Module';
                    $Logmodel->operation_name = 'Edit';
                    $Logmodel->reference_id = $catid;
                    $Logmodel->table_name = 'class_sechedule_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                } else {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Class Schedule Module';
                    $Logmodel->operation_name = 'Insert';
                    $Logmodel->reference_id = $classcategory->classsechedule_id;
                    $Logmodel->table_name = 'class_sechedule_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                }


                return response()->json(['data' => $classcategory]);
                //  }
            }
        }

        //return Response::json($package);
    }
    public function getscedulaclass()
    {
        date_default_timezone_set('Asia/Kolkata');
        // $date = date('d-m-Y H:i', time());
        //dd($date);
        $data = DB::table('class_sechedule_master')

            ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
            ->join('room_master', 'room_master.rooom_id', '=', 'class_sechedule_master.room_id')
            ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
            ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'room_master.room as room', 'instuctor_master.instructor_name')
            ->where('class_schedule', '>', date('Y-m-d H:i:s'))
            ->orderBy('class_schedule', 'DESC')
            ->get();
        return response()->json($data);
    }
    public function deleteclasssechedule($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Class Schedule Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'class_sechedule_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        $customer = Classsechedulemodel::where('classsechedule_id', $id)->delete();
        return Response::json($customer);
    }
    //for update
    public function update(Request $request, $id)
    {
        $user_id = Session::get('login_id');
        $catid = $id;

        $data = DB::table('class_sechedule_master')
            ->select('class_sechedule_master.*')
            ->where('classsechedule_id', $catid)
            ->get();
        $count = count($data);
        $input = $request->all();
        if ($count > 0) {
            if ($catid == "") {
                $validator = Validator::make($input, [
                    'classsechedule_name' => 'required',
                    'instructorid' => 'required',
                    'class_schedule' => 'required',
                    'max_vacancy' => 'required',
                    'class_duration' => 'required',
                    'room_id' => 'required',
                    'min_cancelation' => 'required',
                    'min_booking' => 'required',
                    'statusinfo' => 'required',

                ]);
            } else {

                $validator = Validator::make($input, [
                    'classsechedule_name' => 'required',
                    'instructorid' => 'required',
                    'class_schedule' => 'required',
                    'max_vacancy' => 'required',
                    'class_duration' => 'required',
                    'room_id' => 'required',
                    'min_cancelation' => 'required',
                    'min_booking' => 'required',
                    'statusinfo' => 'required',

                ]);
            }
            // if($validator->fails()){

            //     return response()->json('less Arguments OR Class Category Already Exists ');
            // }else{
            $from1 = strtr($request->class_schedule, '/', '-');
            $class_schedule = date('Y-m-d H:i:s', strtotime($from1));

            $from2 = strtr($request->min_cancelation, '/', '-');
            $min_cancelation = date('Y-m-d H:i:s', strtotime($from2));

            $from3 = strtr($request->min_booking, '/', '-');
            $min_booking = date('Y-m-d H:i:s', strtotime($from3));

            $classcategory   =   Classsechedulemodel::updateOrCreate(
                ['classsechedule_id' => $catid],
                [
                    'classsechedule_name'       =>   $request->classsechedule_name,
                    'class_schedule' => $class_schedule,
                    'instructor' => $request->instructorid,
                    'max_vacancy' => $request->max_vacancy,
                    'class_duration' => $request->class_duration,
                    'room_id' => $request->room_id,
                    'min_cancelation' => $min_cancelation,
                    'min_booking' => $min_booking,
                    'status' => $request->statusinfo,
                    'user_id' => $user_id,

                ]

            );




            if ($catid > 0) {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Class Schedule Module';
                $Logmodel->operation_name = 'Edit';
                $Logmodel->reference_id = $catid;
                $Logmodel->table_name = 'class_sechedule_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            } else {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Class Schedule Module';
                $Logmodel->operation_name = 'Insert';
                $Logmodel->reference_id = $classcategory->classsechedule_id;
                $Logmodel->table_name = 'class_sechedule_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            }


            return response()->json(['data' => $classcategory, 'msg' => 'Data Update SuccessFully']);
            // }
        } else {
            return response()->json(['msg' => 'Data Not Found']);
        }
    }

    //for deleting through api
    public function destroy($id)
    {
        $user_id = Session::get('login_id');
        $customer = Classsechedulemodel::where('classsechedule_id', $id)->delete();
        if ($customer > 0) {
            $Logmodel = new Logmodel;

            $Logmodel->module_name = 'Class Schedule  Module';
            $Logmodel->operation_name = 'Delete';
            $Logmodel->reference_id = $id;
            $Logmodel->table_name = 'class_sechedule_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
            return Response::json(['msg' => 'Delete Class Schedule Successfully',]);
        } else {
            return Response::json(['msg' => 'Delete Class Schedule Not Found Successfully',]);
        }
    }
    public function getsingleclassschedule($id)
    {
        $data = DB::table('class_sechedule_master')

            ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
            ->join('room_master', 'room_master.rooom_id', '=', 'class_sechedule_master.room_id')
            ->where('class_sechedule_master.classsechedule_id', $id)
            ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'room_master.room as room')
            ->get();
        return response()->json($data);
    }
    public function changeclasssechedulestatus($id, $status)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Class Schedule  Module';
        $Logmodel->operation_name = 'Change Status';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'class_sechedule_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();

        $customer = DB::update('update class_sechedule_master set status = ? where classsechedule_id = ?', [$status, $id]);
        return Response::json($customer);
    }
    public function getdropallinstuctor()
    {
        $data = DB::table('instuctor_master')->where('status', 1)->get();
        return response()->json($data);
    }
    public function getNextUserID()
    {

        $statement = DB::select("show table status like 'instuctor_master'");

        return response()->json(['user_id' => $statement[0]->Auto_increment]);
    }



    public function datewise_shedule(Request $request)
    {

        $date = $request->date;
        $result = array();



        // $where=array('class_sechedule_master.class_schedule'=>$date);
        $data = DB::table('class_sechedule_master')
            ->select('class_sechedule_master.*', 'class_master.class_description', 'class_master.class_name as classname', 'instuctor_master.instructor_name', 'instuctor_master.instructor_img')
            ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
            ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
            ->whereDate('class_sechedule_master.class_schedule', $date)
            ->where('class_sechedule_master.status', 1)
            ->get();

        $cnt = count($data);
        if ($cnt > 0) {
            foreach ($data as $val) {
                $schedule_id = $val->classsechedule_id;

                $data2 = DB::table('booking_table')
                    ->select('booking_table.*')
                    ->where('booking_table.is_cancelled', 1)
                    ->where('booking_table.class_schedule_id', $schedule_id)
                    ->get()->count();

                $available = intval($val->max_vacancy) - intval($data2);

                $expire = "";
                date_default_timezone_set('Asia/Kolkata');
                $date = date("Y-m-d H:i:s");
                $schedule = $val->class_schedule;
                if ($schedule > $date) {
                    $expire = "False";
                } else {
                    $expire = "True";
                }

                $result[] = array(
                    'id' => $val->classsechedule_id,
                    'class_schedule' => $val->class_schedule,
                    'class_name' => $val->classname,
                    'instructor_name' => $val->instructor_name,
                    'instructor_image' => $val->instructor_img,
                    'duration' => $val->class_duration,
                    'vacancy' => $val->max_vacancy,
                    'class_description' => $val->class_description,
                    'min_cancelation' => $val->min_cancelation,
                    'min_booking' => $val->min_booking,
                    'status' => $val->status,
                    'available' => $available,
                    'expire' => $expire,
                );
            }
            return response()->json(['data' => $result, 'status' => 1]);
        } else {

            return response()->json(['data' => $result, 'status' => 0]);
        }
    }

    public function booking_api(Request $request)
    {

        $link_id = $request->link_id;
        $points = $request->points;
        $date_time = $request->date_time;
        $class_schedule_id = $request->class_schedule_id;

        $result = array();
        $data = array(
            'link_id' => $link_id,
            'points' => $points,
            'date_time' => $date_time,
            'class_schedule_id' => $class_schedule_id,
        );


        $result =  DB::table('booking_table')
            ->Insert($data);

        $where = array('link_relation_ship.linkrelid' => $link_id);
        $data = DB::table('link_relation_ship')
            ->select('link_relation_ship.*', 'member_master.balancepoint')
            ->join('member_master', 'member_master.member_id', '=', 'link_relation_ship.member_id')
            ->where($where)
            ->first();
        $available = $data->balancepoint;
        $member_id = $data->member_id;
        $total = intval($available) - intval($points);

        $result = DB::table('member_master')
            ->where('member_id', $member_id)
            ->update(['balancepoint' => $total]);



        return response()->json(['status' => 1]);
    }
    public function cancel_booking_api(Request $request)
    {

        $booking_id = $request->booking_id;


        $result = array();



        $result =  DB::table('booking_table')
            ->where('booking_id', $booking_id)
            ->update(['is_cancelled' => 0]);


        $where1 = array('booking_table.booking_id' => $booking_id);
        $data1 = DB::table('booking_table')
            ->select('booking_table.*')
            ->where($where1)
            ->first();
        $link_id = $data1->link_id;
        $points = $data1->points;


        $where = array('link_relation_ship.linkrelid' => $link_id);
        $data = DB::table('link_relation_ship')
            ->select('link_relation_ship.*', 'member_master.balancepoint')
            ->join('member_master', 'member_master.member_id', '=', 'link_relation_ship.member_id')
            ->where($where)
            ->first();
        $available = $data->balancepoint;
        $member_id = $data->member_id;
        $total = intval($available) + intval($points);

        $result = DB::table('member_master')
            ->where('member_id', $member_id)
            ->update(['balancepoint' => $total]);




        return response()->json(['status' => 1]);
    }

    public function rating_api(Request $request)
    {

        $booking_id = $request->booking_id;
        $rating_points = $request->rating_points;


        $result = array();



        $result =  DB::table('booking_table')
            ->where('booking_id', $booking_id)
            ->update(['rating_points' => $rating_points]);




        return response()->json(['status' => 1]);
    }
    public function my_bookings_api(Request $request)
    {
        $link_id = $request->link_id;
        $result = array();
        $result2 = "";


        $data = DB::table('booking_table')
            ->select(DB::raw('DATE(class_sechedule_master.class_schedule) as formatted_date'))
            ->join('class_sechedule_master', 'class_sechedule_master.classsechedule_id', '=', 'booking_table.class_schedule_id')
            //   ->whereDate('class_sechedule_master.class_schedule', $date)
            ->where('booking_table.link_id', $link_id)
            ->where('booking_table.is_cancelled', 1)
            ->where('booking_table.rating_points', -1)
            ->distinct('formatted_date')
            ->orderBy('class_sechedule_master.class_schedule', 'ASC')
            ->get();


        foreach ($data as $val) {
            $class_schedule_date = $val->formatted_date;
            $result2 = array();

            $data2 = DB::table('class_sechedule_master')
                ->select('class_sechedule_master.*', 'class_master.class_description', 'class_master.class_name as classname', 'instuctor_master.instructor_name', 'instuctor_master.instructor_img', 'booking_table.booking_id')
                ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                ->join('booking_table', 'booking_table.class_schedule_id', '=', 'class_sechedule_master.classsechedule_id')
                ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                ->whereDate('class_sechedule_master.class_schedule', $class_schedule_date)
                ->where('class_sechedule_master.status', 1)
                ->where('booking_table.link_id', $link_id)
                ->where('booking_table.is_cancelled', 1)
                ->where('booking_table.rating_points', -1)
                ->get();


            foreach ($data2 as $val2) {
                $schedule_id = $val2->classsechedule_id;

                $data2 = DB::table('booking_table')
                    ->select('booking_table.*')
                    ->where('booking_table.is_cancelled', 1)
                    ->where('booking_table.class_schedule_id', $schedule_id)
                    ->get()->count();

                $available = intval($val2->max_vacancy) - intval($data2);

                $expire = "";
                date_default_timezone_set('Asia/Kolkata');
                $date = date("Y-m-d H:i:s");
                $schedule = $val2->class_schedule;
                if ($schedule > $date) {
                    $expire = "False";
                } else {
                    $expire = "True";
                }

                $result2[] = array(
                    'id' => $val2->classsechedule_id,
                    'booking_id' => $val2->booking_id,
                    'class_schedule' => $val2->class_schedule,
                    'class_name' => $val2->classname,
                    'instructor_name' => $val2->instructor_name,
                    'instructor_image' => $val2->instructor_img,
                    'duration' => $val2->class_duration,
                    'vacancy' => $val2->max_vacancy,
                    'class_description' => $val2->class_description,
                    'min_cancelation' => $val2->min_cancelation,
                    'min_booking' => $val2->min_booking,
                    'status' => $val2->status,
                    'available' => $available,
                    'expire' => $expire,
                );
            }
            $result[] = array('date' => $class_schedule_date, 'booking' => $result2);
        }






        return response()->json($result);
    }

    public function my_bookings_details_api(Request $request)
    {
        $link_id = $request->link_id;
        $class_schedule_id = $request->classsechedule_id;
        $result = array();
        //   $result = "";

        $data1 = DB::table('class_sechedule_master')
            ->select('class_sechedule_master.*', 'class_master.class_description', 'class_master.class_name as classname', 'instuctor_master.instructor_name', 'instuctor_master.instructor_img')
            ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
            ->join('instuctor_master', 'class_sechedule_master.instructor', '=', 'instuctor_master.instructorid')
            ->where('class_sechedule_master.status', 1)
            ->where('class_sechedule_master.classsechedule_id', $class_schedule_id)
            ->get();
        //   select * from class_sechedule_master csm left join booking_table bt on bt.class_schedule_id = csm.classsechedule_id where csm.classsechedule_id = 16

        foreach ($data1 as $val2) {



            $schedule_id = $val2->classsechedule_id;

            $data2 = DB::table('booking_table')
                ->select('booking_table.*')
                ->where('booking_table.is_cancelled', 1)
                ->where('booking_table.class_schedule_id', $schedule_id)
                ->get()->count();

            $data3 = DB::table('booking_table')
                ->select('booking_table.*')
                ->where('booking_table.is_cancelled', 1)
                ->where('booking_table.class_schedule_id', $schedule_id)
                ->where('booking_table.link_id', $link_id)
                ->get()->count();

            $available = intval($val2->max_vacancy) - intval($data2);

            $expire = "";
            date_default_timezone_set('Asia/Kolkata');
            $date = date("Y-m-d H:i:s");
            $schedule = $val2->class_schedule;
            if ($schedule > $date) {
                $expire = "False";
            } else {
                $expire = "True";
            }
            $is_booked = "";
            if ($data3 > 0) {
                $is_booked = "True";
            } else {
                $is_booked = "False";
            }

            $result= array(
                'id' => $val2->classsechedule_id,
                'class_schedule' => $val2->class_schedule,
                'class_name' => $val2->classname,
                'instructor_name' => $val2->instructor_name,
                'instructor_image' => $val2->instructor_img,
                'duration' => $val2->class_duration,
                'vacancy' => $val2->max_vacancy,
                'class_description' => $val2->class_description,
                'min_cancelation' => $val2->min_cancelation,
                'min_booking' => $val2->min_booking,
                'status' => $val2->status,
                'available' => $available,
                'is_booked' => $is_booked,
                'expire' => $expire,
            );
        }
        $result = array('data' => $result);

        return response()->json($result);
    }
}
