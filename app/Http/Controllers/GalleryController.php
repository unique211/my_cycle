<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallarymodel;
use Session;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;

class GalleryController extends Controller
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
            return view('gallery', $data);
        }
    }

    public function galleryuploadimg(Request $request)
    {


        $extension = $request->file('file')->getClientOriginalExtension();

        $dir = 'gallaryimg/';
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // echo  dd($filename);
        $request->file('file')->move($dir, $filename);


        return $filename;
    }

    public function store(Request $request) //For insert or Update Record Of Room Master --
    {

        $user_id = Session::get('login_id');
        $catid = $request->save_update;

        $input = $request->all();


        //  dd($request->uploadimg_hidden);
        if ($catid == "") {
            $validator = Validator::make($input, [
                'uploadimg_hidden' => 'required',

                'desc' => 'required',
                'allowshare' => 'required',


            ]);
        } else {
            $validator = Validator::make($input, [
                'uploadimg_hidden' => 'required',

                'desc' => 'required',
                'allowshare' => 'required',

            ]);
        }
        if ($validator->fails()) {

            return response()->json('less Arguments ');
        } else {

            $split = explode('.', $request->uploadimg_hidden, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

            $mp4 = $split[1];
            $is_video = "";
            if ($mp4 == "mp4") {
                $is_video = "1";
            } else {
                $is_video = "0";
            }

            $dealdata   =   Gallarymodel::updateOrCreate(
                ['gallary_id' => $catid],
                [
                    'uploadimg'       =>   $request->uploadimg_hidden,
                    'description' => $request->desc,
                    'allowshare' => $request->allowshare,
                    'is_video' => $is_video,
                    'user_id' => $user_id,

                ]

            );




            if ($catid > 0) {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Gallary Master Module';
                $Logmodel->operation_name = 'Edit';
                $Logmodel->reference_id = $catid;
                $Logmodel->table_name = 'gallary_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            } else {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Gallary Master Module';
                $Logmodel->operation_name = 'Insert';
                $Logmodel->reference_id = $dealdata->gallary_id;
                $Logmodel->table_name = 'gallary_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            }


            return response()->json(['data' => $dealdata]);
        }

        //return Response::json($package);
    }
    public function getallgallary($id)
    {
        if ($id == 1) {
            $data = DB::table('gallary_master')
                ->select('gallary_master.*')
                ->where('allowshare', 1)
                ->orderBy('gallary_id', 'DESC')
                ->get();
        } else {
            $data = DB::table('gallary_master')
                ->select('gallary_master.*')
                ->where('allowshare', 0)
                ->orderBy('gallary_id', 'DESC')
                ->get();
        }


        return Response::json($data);
    }

    public function getallgallary_all_data()
    {
        $data = DB::table('gallary_master')
            ->select('gallary_master.*')
            ->orderBy('gallary_id', 'DESC')

            ->get();

        return Response::json($data);
    }

    public function getsingleallgallary($id)
    {
        $data = DB::table('gallary_master')
            ->select('gallary_master.*')
            ->where('allowshare', 1)
            ->where('gallary_id', $id)
            ->orderBy('gallary_id', 'DESC')

            ->get();
        $count = count($data);
        if ($count > 0) {
            return Response::json($data);
        } else {
            return Response::json(['msg' => 'Record Not Found']);
        }
    }
    public function changepostshare($id, $status)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Gallary Master Module';
        $Logmodel->operation_name = 'Change Allowshare';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'gallary_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();

        $customer = DB::update('update gallary_master set allowshare = ? where gallary_id = ?', [$status, $id]);
        return Response::json($customer);
    }
    public function deletegallary($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Gallary Master Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'gallary_master';
        $Logmodel->user_id = $user_id;
        // $Logmodel->table_name = 'package_master';
        $Logmodel->save();
        $customer = Gallarymodel::where('gallary_id', $id)->delete();
        return Response::json($customer);
    }

    //for api update

    public function update(Request $request, $id)
    {
        $catid = $id;
        $user_id = Session::get('login_id');
        $input = $request->all();


        //  dd($request->uploadimg_hidden);
        if ($catid == "") {
            $validator = Validator::make($input, [
                'uploadimg_hidden' => 'required',

                'desc' => 'required',
                'allowshare' => 'required',


            ]);
        } else {
            $validator = Validator::make($input, [
                'uploadimg_hidden' => 'required',

                'desc' => 'required',
                'allowshare' => 'required',

            ]);
        }
        if ($validator->fails()) {

            return response()->json('less Arguments ');
        } else {

            $split = explode('.', $request->uploadimg_hidden, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

            $mp4 = $split[1];
            $is_video = "";
            if ($mp4 == "mp4") {
                $is_video = "1";
            } else {
                $is_video = "0";
            }



            $dealdata   =   Gallarymodel::updateOrCreate(
                ['gallary_id' => $catid],
                [
                    'uploadimg'       =>   $request->uploadimg_hidden,
                    'description' => $request->desc,
                    'allowshare' => $request->allowshare,
                    'is_video' => $is_video,
                    'user_id' => $user_id,

                ]

            );




            if ($catid > 0) {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Gallary Master Module';
                $Logmodel->operation_name = 'Edit';
                $Logmodel->reference_id = $catid;
                $Logmodel->table_name = 'gallary_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            } else {
                $Logmodel = new Logmodel;

                $Logmodel->module_name = 'Gallary Master Module';
                $Logmodel->operation_name = 'Insert';
                $Logmodel->reference_id = $dealdata->gallary_id;
                $Logmodel->table_name = 'gallary_master';
                $Logmodel->user_id = $user_id;
                $Logmodel->save();
            }


            return response()->json(['data' => $dealdata]);
        }
    }
    public function destroy($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Gallary Master Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'gallary_master';
        $Logmodel->user_id = $user_id;
        // $Logmodel->table_name = 'package_master';
        $Logmodel->save();
        $customer = Gallarymodel::where('gallary_id', $id)->delete();
        if ($customer > 0) {
            return Response::json(['msg' => 'Delete Record  Successfully',]);
        } else {
            return Response::json(['msg' => 'Delete Record Not Successfully',]);
        }
    }

    public function gallery_api(Request $request)
    {

        $link_id = $request->link_id;
        $data = DB::table('gallary_master')
            ->select('gallary_master.*')

            ->get();
        $result = array();



        foreach ($data as $val) {
            $post_id = $val->gallary_id;

            $video = "";
            $desc = "";
            $is_video = $val->is_video;
            if ($is_video == 0) {
                $video = "No";
            } else {
                $video = "Yes";
            }
            $description = $val->description;
            if ($description == null) {
                $desc = "";
            } else {
                $desc = $description;
            }
            $isLiked = 0;
            $data1 = DB::table('gallary_liked_master')
                ->select('gallary_liked_master.*')
                ->where('post_id', $post_id)
                ->where('link_id', $link_id)
                ->get();
            $cnt1 = count($data1);

            if ($cnt1 > 0) {
                $isLiked = 1;
            }
            $result[] = array(
                'user_name' => "",
                'post_id' => $val->gallary_id,
                'description' => $desc,
                'image_video_url' => $val->uploadimg,
                'is_video' => $video,
                'posting_date_time' => $val->created_at,
                'likes_count' => $val->nooflike,
                'is_allow_to_share' => $val->allowshare,
                'is_liked' => $isLiked,

            );
        }


        return response()->json($result);
    }

    public function gallery_post_addlike(Request $request)
    {

        $post_id = $request->post_id;
        $link_id = $request->link_id;
        $data1 = DB::table('gallary_liked_master')
            ->select('gallary_liked_master.*')
            ->where('post_id', $post_id)
            ->where('link_id', $link_id)
            ->get();
        $cnt1 = count($data1);

        if ($cnt1 > 0) {


            $data = DB::table('gallary_master')
                ->select('gallary_master.*')
                ->where('gallary_id', $post_id)
                ->get();
            $cnt = count($data);
            if ($cnt > 0) {
                foreach ($data as $val) {
                    $total_likes = $val->nooflike;


                    $minus = intval($total_likes) - 1;

                    $set = array('nooflike' => $minus);

                    DB::table('gallary_master')
                        ->where('gallary_id', $post_id)
                        ->update($set);

                    DB::table('gallary_liked_master')
                        ->where('post_id', $post_id)
                        ->where('link_id', $link_id)
                        ->delete();
                }
            }
            return response()->json(['status' => 0, 'message' => 'UnLiked']);
        } else {
            $data = DB::table('gallary_master')
                ->select('gallary_master.*')
                ->where('gallary_id', $post_id)
                ->get();
            $cnt = count($data);
            if ($cnt > 0) {
                foreach ($data as $val) {
                    $total_likes = $val->nooflike;


                    $plus = intval($total_likes) + 1;

                    $set = array('nooflike' => $plus);

                    DB::table('gallary_master')
                        ->where('gallary_id', $post_id)
                        ->update($set);

                    date_default_timezone_set('Asia/Kolkata');
                    $date = date("Y-m-d H:i:s");

                    $insert = array(
                        'link_id' => $link_id,
                        'post_id' => $post_id,
                        'add_date' => $date,
                    );
                    $inser_data =  DB::table('gallary_liked_master')
                        ->Insert($insert);
                }
                return response()->json(['status' => 1, 'message' => 'Liked']);
            } else {
                return response()->json(['status' => -1, 'message' => 'This Post is Not Available']);
            }
        }









        $data = DB::table('gallary_master')
            ->select('gallary_master.*')
            ->where('gallary_id', $post_id)

            ->get();
        $cnt = count($data);
        if ($cnt > 0) {

            return response()->json(['status' => 0, 'message' => 'Already Liked']);
        } else {
            foreach ($data as $val) {
                $total_likes = $val->nooflike;


                $plus = intval($total_likes) + 1;

                $set = array('nooflike' => $plus);

                DB::table('gallary_master')
                    ->where('gallary_id', $post_id)
                    ->update($set);
            }
            return response()->json(['status' => 1]);
        }
    }

    public function get_notifications_api(Request $request)
    {


        $data = DB::table('member_notification')
            ->select('member_notification.*')
            ->where('link_ref_id', $request->link_ref_id)
            ->where('status', 1)
            ->get();
        $result = array();



        foreach ($data as $val) {


            $result[] = array(
                'n_id' => $val->n_id,
                'notification_msg' => $val->notification_msg,
                'msg_type' => $val->msg_type,
            );
        }


        return response()->json($result);
    }

    public function delete_notifications_api(Request $request)
    {


        $data = DB::table('member_notification')
            ->select('member_notification.*')
            ->where('n_id', $request->n_id)
            ->get()->count();




        if ($data > 0) {
            $result = DB::table('member_notification')
                ->where('n_id', $request->n_id)
                ->update(['status' => 0]);

            return response()->json(['status' => 1, 'message' => "Notification Deleted"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Not Found"]);
        }
    }
}
