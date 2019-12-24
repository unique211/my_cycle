<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use Validator;
use App\Logmodel;
use Session;
class MobileNotificationController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('mobile_notification');
        }
    }
    public function get_all_members()
    {

        $data = DB::table('link_relation_ship')
            ->select('link_relation_ship.*')
            ->where('status', 1)
            ->get();
        return Response::json($data);
    }
    public function store(Request $request)
    {
        $user_id = Session::get('login_id');
        $id = $request->save_update;
        $table_id="";
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s");

        if ($id == "") {
            $data = array(
                'notification_text' => $request->notification_text,
                'member_list' => $request->member_list,
                'count' => $request->count,
                'created_at' => $date,
                'updated_at' => $date,
                'user_id' => $user_id,
            );
            $result =  DB::table('notification_master')
                ->InsertGetId($data);

            $table_id = $result;



                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Notification Master Module';
                $Logmodel->operation_name = 'Insert';
                $Logmodel->reference_id = $table_id;
                $Logmodel->table_name = 'notification_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();



        } else {
            $data = array(
                'notification_text' => $request->notification_text,
                'member_list' => $request->member_list,
                'count' => $request->count,
                'updated_at' => $date,
                'user_id' => $user_id,
            );
            $result = DB::table('notification_master')
                ->where('id', $id)
                ->update($data);
            $table_id = $id;

            $Logmodel = new Logmodel;

            $Logmodel->module_name = 'Notification Master Module';
            $Logmodel->operation_name = 'Edit';
            $Logmodel->reference_id = $table_id;
            $Logmodel->table_name = 'notification_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();


        }
        return Response::json($table_id);
        //return Response::json($package);
    }

    public function get_all_notifications()
    {
        $data = DB::table('notification_master')
            ->select('notification_master.*')
            ->where('status', 1)
            ->orderBy('notification_master.id', 'DESC')
            ->get();
        return Response::json($data);
    }
}
