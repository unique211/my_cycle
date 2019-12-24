<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;

use App\Logmodel;
use Validator;

class AttendenceRatingController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('attendence_rating');
        }


    }
    public function getattandancedata(Request $request){
        $result=array();



        $fromdate=$request->from;

        $to=$request->to;
        $instructorid=$request->instructorid;
        $classid=$request->classid;


        $data = DB::table('booking_table')
         ->join('link_relation_ship', 'link_relation_ship.linkrelid', '=', 'booking_table.link_id')

       ->whereDate('date_time', '>=', $fromdate)
       // ->whereDate('date_time', '<=', $to)
        ->where('is_cancelled',1)

        ->select('booking_table.*', 'link_relation_ship.name as membername','link_relation_ship.userid')
        ->orderBy('booking_table.date_time', 'asc')
        ->get();
        $count=count($data);


        if($count >0){
            foreach($data as $bookinginfo){
                $classname='';
                $instructorname='';
                $bookid=$bookinginfo->booking_id;
                $link_id=$bookinginfo->link_id;
                $points=$bookinginfo->points;
                $class_schedule_id=$bookinginfo->class_schedule_id;
                $rating_points=$bookinginfo->rating_points;
                $attandancestatus=$bookinginfo->attandancestatus;
                $membername=$bookinginfo->membername;
                $userid=$bookinginfo->userid;
                $date_time=$bookinginfo->date_time;
                $data1='';



                if($classid=='All' &&  $instructorid=='All'){
                    $data1 = DB::table('class_sechedule_master')
                    ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                    ->where('class_sechedule_master.classsechedule_id',$class_schedule_id)
                    ->select('class_sechedule_master.*', 'class_master.class_name as classname','instuctor_master.instructor_name as instructorname')
                     ->get();
                }else if($classid >0 && $instructorid=='All'){
                    $data1 = DB::table('class_sechedule_master')
                    ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                    ->where('class_sechedule_master.classsechedule_name',$classid)
                    ->where('class_sechedule_master.classsechedule_id',$class_schedule_id)
                    ->select('class_sechedule_master.*', 'class_master.class_name as classname','instuctor_master.instructor_name as instructorname')
                     ->get();
                }else if($classid =='All' && $instructorid >0){
                    $data1 = DB::table('class_sechedule_master')
                    ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                    ->where('class_sechedule_master.instructor',$instructorid)
                    ->where('class_sechedule_master.classsechedule_id',$class_schedule_id)
                    ->select('class_sechedule_master.*', 'class_master.class_name as classname','instuctor_master.instructor_name as instructorname')
                     ->get();
                }else if($classid > 0 && $instructorid >0){

                    // $data1 = DB::table('class_sechedule_master')
                    // ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    // ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor ')
                    // ->where('class_sechedule_master.classsechedule_id',$class_schedule_id)


                    // ->select('class_sechedule_master.*', 'class_master.class_name as classname','instuctor_master.instructor_name as instructorname')
                    // ->where('class_sechedule_master.classsechedule_name',$classid)
                    // ->where('class_sechedule_master.instructor',$instructorid)
                    // ->get();

                    $data1 = DB::table('class_sechedule_master')
                    ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                    ->where('class_sechedule_master.instructor',$instructorid)
                    ->where('class_sechedule_master.classsechedule_id',$class_schedule_id)
                    ->where('class_sechedule_master.classsechedule_name',$classid)
                    ->select('class_sechedule_master.*', 'class_master.class_name as classname','instuctor_master.instructor_name as instructorname')
                     ->get();
                }
                $count1=count($data1);

                if($count1 >0){
                    foreach( $data1 as $classsecheduledata){

                        $classname=$classsecheduledata->classname;
                        $instructorname=$classsecheduledata->instructorname;

                    }
                }

                $result[]=array(
                    'bookid'=>$bookid,
                    'link_id'=>$link_id,
                    'points'=>$points,
                    'link_id'=>$link_id,
                    'class_schedule_id'=>$class_schedule_id,
                    'rating_points'=>$rating_points,
                    'attandancestatus'=>$attandancestatus,
                    'membername'=>$membername,
                    'userid'=>$userid,
                    'classname'=>$classname,
                    'instructorname'=>$instructorname,
                    'date_time'=>$date_time,
                );

            }
        }

        return $result;


    }
}
