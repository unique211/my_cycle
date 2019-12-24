<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use Session;
use Validator;


class Dashboardcontroller extends Controller
{
    //
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

            return view('home',$data);
        }
    }

    public function upcoming_booking_details()
    {
        $result = array();

        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s");

        $data = DB::table('class_sechedule_master')
            ->select('class_sechedule_master.*', 'class_master.class_name as classname', 'instuctor_master.instructor_name')
            ->join('class_master', 'class_master.class_id', '=', 'class_sechedule_master.classsechedule_name')
            ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
            ->whereDate('class_sechedule_master.class_schedule', '<=', $date)
            ->orderBy('class_schedule', 'ASC')
            ->get();

        foreach ($data as $val) {
            $class_schedule_id = $val->classsechedule_id;
            $data2 = DB::table('booking_table')
                ->select('booking_table.*')
                ->where('booking_table.is_cancelled', 1)
                ->where('booking_table.class_schedule_id', $class_schedule_id)
                ->get()->count();

            $result[] = array(
                'id' => $val->classsechedule_id,
                'date' => $val->class_schedule,
                'class' => $val->classname,
                'instructor' => $val->instructor_name,
                'members_count' => $data2,

            );
        }

        return response()->json($result);
    }
}
