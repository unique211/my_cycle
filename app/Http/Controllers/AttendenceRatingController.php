<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use Session;
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
            return view('attendence_rating', $data);
        }
    }
    public function getattandancedata(Request $request)
    {
        $result = array();



        $fromdate = $request->from;

        $to = $request->to;
        $instructorid = $request->instructorid;
        $classid = $request->classid;


        $data = DB::table('booking_table')
            ->join('link_relation_ship', 'link_relation_ship.linkrelid', '=', 'booking_table.link_id')

            ->whereDate('date_time', '>=', $fromdate)
            // ->whereDate('date_time', '<=', $to)
            ->where('is_cancelled', 1)

            ->select('booking_table.*', 'link_relation_ship.name as membername', 'link_relation_ship.userid')
            ->orderBy('booking_table.date_time', 'asc')
            ->get();
        $count = count($data);


        if ($count > 0) {
            foreach ($data as $bookinginfo) {
                $classname = '';
                $instructorname = '';
                $bookid = $bookinginfo->booking_id;
                $link_id = $bookinginfo->link_id;
                $points = $bookinginfo->points;
                $class_schedule_id = $bookinginfo->class_schedule_id;
                $rating_points = $bookinginfo->rating_points;
                $attandancestatus = $bookinginfo->attandancestatus;
                $membername = $bookinginfo->membername;
                $userid = $bookinginfo->userid;
                $date_time = $bookinginfo->date_time;
                $data1 = '';



                if ($classid == 'All' &&  $instructorid == 'All') {
                    $data1 = DB::table('class_sechedule_master')
                        ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                        ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                        ->where('class_sechedule_master.classsechedule_id', $class_schedule_id)
                        ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name as instructorname')
                        ->get();
                } else if ($classid > 0 && $instructorid == 'All') {
                    $data1 = DB::table('class_sechedule_master')
                        ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                        ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                        ->where('class_sechedule_master.classsechedule_name', $classid)
                        ->where('class_sechedule_master.classsechedule_id', $class_schedule_id)
                        ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name as instructorname')
                        ->get();
                } else if ($classid == 'All' && $instructorid > 0) {
                    $data1 = DB::table('class_sechedule_master')
                        ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                        ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                        ->where('class_sechedule_master.instructor', $instructorid)
                        ->where('class_sechedule_master.classsechedule_id', $class_schedule_id)
                        ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name as instructorname')
                        ->get();
                } else if ($classid > 0 && $instructorid > 0) {

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
                        ->where('class_sechedule_master.instructor', $instructorid)
                        ->where('class_sechedule_master.classsechedule_id', $class_schedule_id)
                        ->where('class_sechedule_master.classsechedule_name', $classid)
                        ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name as instructorname')
                        ->get();
                }
                $count1 = count($data1);

                if ($count1 > 0) {
                    foreach ($data1 as $classsecheduledata) {

                        $classname = $classsecheduledata->classname;
                        $instructorname = $classsecheduledata->instructorname;
                    }
                }

                $result[] = array(
                    'bookid' => $bookid,
                    'link_id' => $link_id,
                    'points' => $points,
                    'link_id' => $link_id,
                    'class_schedule_id' => $class_schedule_id,
                    'rating_points' => $rating_points,
                    'attandancestatus' => $attandancestatus,
                    'membername' => $membername,
                    'userid' => $userid,
                    'classname' => $classname,
                    'instructorname' => $instructorname,
                    'date_time' => $date_time,
                );
            }
        }

        return $result;
    }


    //for class booking report function
    public function get_class_booking_report(Request $request)
    {
        $result = array();

        //request of post data
        $fromdate = $request->from;
        $to = $request->to;
        $instructorid = $request->instructorid;
        $classid = $request->classid;
        $member_id = $request->member_id;


        //     $data = DB::table('booking_table')
        //     ->join('link_relation_ship', 'link_relation_ship.linkrelid', '=', 'booking_table.link_id')

        //   ->whereDate('date_time', '>=', $fromdate)
        //    ->whereDate('date_time', '<=', $to)
        //    ->where('is_cancelled',1)

        //    ->select('booking_table.*', 'link_relation_ship.name as membername','link_relation_ship.userid')
        //    ->orderBy('booking_table.date_time', 'asc')
        //    ->get();
        //    $count=count($data);
        $where = array();
        if ($member_id > 0) {
            $where = array('booking_table.is_cancelled' => 1, 'link_relation_ship.member_id' => $member_id);
        } else {
            $where = array('booking_table.is_cancelled' => 1);
        }


        $data = DB::table('booking_table')
            ->select('booking_table.*', 'link_relation_ship.member_id')
            ->join('link_relation_ship', 'link_relation_ship.linkrelid', '=', 'booking_table.link_id')
            ->where($where)
            ->whereDate('booking_table.date_time', '>=', $fromdate)
            ->whereDate('booking_table.date_time', '<=', $to)
            ->orderBy('booking_table.date_time', 'asc')
            ->get();
           // dd($data);
        $count = count($data);
        if ($count > 0) {
            foreach ($data as $value) {
                $class_schedule_id = $value->class_schedule_id;


                $where1 = array();
                if ($classid > 0) {

                    if ($instructorid > 0) {
                        $where1 = array('class_sechedule_master.classsechedule_id' => $class_schedule_id, 'class_sechedule_master.instructor' => $instructorid, 'class_sechedule_master.classsechedule_name' => $classid);
                    } else {
                        $where1 = array('class_sechedule_master.classsechedule_id' => $class_schedule_id, 'class_sechedule_master.classsechedule_name' => $classid);
                    }
                } else {
                    if ($instructorid > 0) {
                        $where1 = array('class_sechedule_master.classsechedule_id' => $class_schedule_id, 'class_sechedule_master.instructor' => $instructorid);
                    } else {
                        $where1 = array('class_sechedule_master.classsechedule_id' => $class_schedule_id);
                    }
                }


                $data1 = DB::table('class_sechedule_master')
                    ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
                    ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                    ->where($where1)
                    ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name as instructorname')
                    ->get();
                $count1 = count($data1);
                if ($count1 > 0) {
                    foreach ($data1 as $val) {

                        $schedule_id = $val->classsechedule_id;

                        $booked_members = DB::table('booking_table')
                            ->select('booking_table.*')
                            ->where('booking_table.is_cancelled', 1)
                            ->where('booking_table.class_schedule_id', $schedule_id)
                            ->get()->count();


                        $result[] = array(
                            'class_name' => $val->classname,
                            'schedule' => $val->class_schedule,
                            'instructor_name' => $val->instructorname,
                            'booked_members' => $booked_members,
                            'vacancy' => $val->max_vacancy,

                        );
                    }
                }
            }
        }




        return $result;
    }
}
