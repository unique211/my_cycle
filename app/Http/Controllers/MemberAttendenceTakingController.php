<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Memberattandancemodel;
use App\Logmodel;
use Validator;
use Session;

class MemberAttendenceTakingController extends Controller
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
            return view('member_attendence_taking',$data);
        }

    }
    public function getbetweenclasssechedule(Request $request){

       $starttime= $request->start_time;
       $endtime= $request->end_time;

       //dd($endtime);
       $result=array();

       $data= DB::table('class_sechedule_master')->where('class_schedule','>=',$starttime)->where('class_schedule','<=',$endtime)->get();
        $count=count($data);

       if($count >0){
         foreach($data as $classsecheduledata){
             $classsechedule_name=$classsecheduledata->classsechedule_name;
             $class_schedule=$classsecheduledata->class_schedule;
             $classsechedule_id=$classsecheduledata->classsechedule_id;
             $instructorid=$classsecheduledata->instructor;
             $max_vacancy=$classsecheduledata->max_vacancy;
             $class_duration=$classsecheduledata->class_duration;
             $room_id=$classsecheduledata->room_id;
                $classname="";
                $instructorname="";





           $classinfo=  DB::table('class_master')->where('class_id',$classsechedule_name)->get();
           foreach($classinfo as $classdata){
            $classname=$classdata->class_name;
           }

           $instructor=  DB::table('instuctor_master')->where('instructorid',$instructorid)->get();
           foreach($instructor as $instructordata){
            $instructorname=$instructordata->instructor_name;
           }
           $result[]=array(
                'classname'=>$classname,
                'class_schedule'=>$class_schedule,
                'instructorname'=>$instructorname,
                'max_vacancy'=>$max_vacancy,
                'class_duration'=>$class_duration,
                'room_id'=>$room_id,
                'classsechedule_id'=>$classsechedule_id,
           );


        }
       }

       return response()->json($result);


    }
    public function getsechedulemember(Request $request){
            $classid=$request->classid;


            $data = DB::table('booking_table')

            ->join('link_relation_ship', 'link_relation_ship.linkrelid', '=', 'booking_table.link_id')
            ->where('booking_table.class_schedule_id',$classid)
            ->where('is_cancelled',1)
            ->select('booking_table.*', 'link_relation_ship.name as membername')
                ->get();

            return response()->json( $data);



    }
    public function store(Request $request){

        $attadance_id = $request->save_update;
        $user_id = Session::get('login_id');

        // $package   =   Memberattandancemodel::updateOrCreate(
        //     ['attadance_id' => $attadance_id],
        //     [
        //         'class_sechedule_id'       =>   $request->class_schedule,
        //         'starttime'       =>   $request->start_time,
        //         'endtime'       =>   $request->end_time,
        //         'attdancedate'       =>   $request->date,
        //         'user_id'       => 1,


        //     ]

        // );
        $urdata = $request->studejsonObj;




        foreach ($urdata as $value) {
            DB::update('update booking_table set attandancestatus = ? where booking_id = ?',[$value["bookvalvalue"],$value["bookidid"]]);
        }



        if($attadance_id==""){
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Member Attadance Module' ;
            $Logmodel->operation_name ='Insert';
            $Logmodel->reference_id =$request->class_schedule;
            $Logmodel->table_name = 'membertype_master';
            $Logmodel->user_id = $user_id;

            $Logmodel->save();
            return response()->json(true);
        }else{
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Member Attadance Module' ;
            $Logmodel->operation_name ='Edit';
            $Logmodel->reference_id = $attadance_id;
            $Logmodel->table_name = 'meber_attandance';
            $Logmodel->user_id = $user_id;

            $Logmodel->save();
            return response()->json(['data'=> true]);
        }



    }
    public function getallattebdance(){

        $result=array();
        $data = DB::table('meber_attandance')
            ->where('status',1)
             ->get();
            foreach($data as $attandance){
                $id=$attandance->attadance_id;
                $class_sechedule_id=$attandance->class_sechedule_id;
                $starttime=$attandance->starttime;
                $endtime=$attandance->endtime;
                $attdancedate=$attandance->attdancedate;
                $classname='';

                $data1 = DB::table('class_sechedule_master')
                    ->where('classsechedule_id', $class_sechedule_id)
                    ->get();

                    foreach($data1 as $classdata){
                        $classsechedule_name=$classdata->classsechedule_name;

                        $data1 = DB::table('class_master')
                        ->where('class_id', $class_sechedule_id)
                        ->get();
                        foreach ($data1 as $classinfo) {
                            $classname=$classinfo['class_name'];
                        }
                    }

        $result[]=array(
                'attadance_id'=>$id,
                'class_sechedule_id'=>$class_sechedule_id,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'attdancedate'=>$attdancedate,
                'classname'=>$classname,


               );

            }

        return response()->json($result);
    }
}
