<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealmodel;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;

class DealsController extends Controller
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
            return view('deals',$data);
        }

    }
    public function store(Request $request) //For insert or Update Record Of Room Master --
    {

        $user_id = Session::get('login_id');
        $catid = $request->save_update;

        $input = $request->all();

        //  dd($request->uploadimg_hidden);
        if ($catid == "") {
            $validator = Validator::make($input, [
                'deal_title' => 'required',
                //'uploadimg_hidden'=>'required',
                'start_date' => 'required',
                'end_date' => 'required',


            ]);
        } else {
            $validator = Validator::make($input, [
                'deal_title' => 'required',
                // 'uploadimg_hidden'=>'required',
                'start_date' => 'required',
                'end_date' => 'required',

            ]);
        }
        if ($validator->fails()) {

            return response()->json('less Arguments OR Dealtitle Already Exists ');
        } else {
            // $from1 = strtr($request->start_date, '/', '-');
            // $start_date= date('Y-m-d', strtotime($from1));

            // $from2 = strtr($request->end_date, '/', '-');
            // $end_date= date('Y-m-d', strtotime($from2));

            $from1 = strtr($request->start_date, '/', '-');
            $start_date = date('Y-m-d H:i:s', strtotime($from1));

            $from1 = strtr($request->end_date, '/', '-');
            $end_date = date('Y-m-d H:i:s', strtotime($from1));

            if ($catid > 0) {
                $data = DB::table('deal_master')->where('deal_title', $request->deal_title)->where('deal_id', '!=', $catid)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('100');
                } else {

                    $split = explode('.', $request->uploadimg_hidden, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

                    $mp4 = $split[1];
                    $is_video = "";
                    if ($mp4 == "mp4") {
                        $is_video = "1";
                    } else {
                        $is_video = "0";
                    }

                    $dealdata   =   Dealmodel::updateOrCreate(
                        ['deal_id' => $catid],
                        [
                            'deal_title'       =>   $request->deal_title,
                            'upload_img' => $request->uploadimg_hidden,
                            'is_video' => $is_video,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'user_id' => $user_id,

                        ]

                    );




                    if ($catid > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Deal Master Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $catid;
                        $Logmodel->table_name = 'deal_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Deal Master Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $dealdata->deal_id;
                        $Logmodel->table_name = 'deal_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data' => $dealdata]);
                }
            } else {
                $data = DB::table('deal_master')->where('deal_title', $request->deal_title)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('100');
                } else {
                    $split = explode('.', $request->uploadimg_hidden, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

                    $mp4 = $split[1];
                    $is_video = "";
                    if ($mp4 == "mp4") {
                        $is_video = "1";
                    } else {
                        $is_video = "0";
                    }

                    $dealdata   =   Dealmodel::updateOrCreate(
                        ['deal_id' => $catid],
                        [
                            'deal_title'       =>   $request->deal_title,
                            'upload_img' => $request->uploadimg_hidden,
                            'is_video' => $is_video,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'user_id' => $user_id,

                        ]

                    );




                    if ($catid > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Deal Master Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $catid;
                        $Logmodel->table_name = 'deal_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Deal Master Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $dealdata->deal_id;
                        $Logmodel->table_name = 'deal_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data' => $dealdata]);
                }
            }
        }

        //return Response::json($package);
    }
    public function uploadingfile(Request $request)
    {


        $extension = $request->file('file')->getClientOriginalExtension();

        $dir = 'uploads/';
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // echo  dd($filename);
        $request->file('file')->move($dir, $filename);


        return $filename;
    }


    //for cheching Deal Title Exist Or not
    public function checkdealtitleexist($name)
    {
        $data = DB::table('deal_master')->where('deal_title', $name)->get();
        $count = count($data);

        return response()->json($count);
    }
    public function editcheckdealtitleexist($name, $id)
    {
        $data = DB::table('deal_master')->where('deal_title', $name)->where('deal_id', '!=', $id)->get();
        $count = count($data);

        return response()->json($count);
    }

    //for gettting all Deal Data
    public function getalldeal()
    {
        $data = DB::table('deal_master')
            //->where('end_date','>',date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'DESC')
           // ->orderBy('login_master.login_id', 'DESC')
            ->get();

        return response()->json($data);
    }
    //for getting single record
    public function getsingledeal($id)
    {
        $data = DB::table('deal_master')->where('deal_id', $id)->get();

        $count = count($data);

        if ($count > 0) {
            return response()->json($data);
        } else {
            return response()->json(['msg' => 'Record Not Found']);
        }
    }

    //for deleting deals

    public function deletedeals($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;



        $Logmodel->module_name = 'Deal Master Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'deal_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        $customer = Dealmodel::where('deal_id', $id)->delete();
        return Response::json($customer);
    }

    //for update
    public function update(Request $request, $id)
    {
        $user_id = Session::get('login_id');
        $catid = $id;
        $data = DB::table('deal_master')
            ->select('deal_master.*')
            ->where('deal_id', $catid)
            ->get();
        $count = count($data);
        if ($count > 0) {


            $input = $request->all();

            //  dd($request->uploadimg_hidden);
            if ($catid == "") {
                $validator = Validator::make($input, [
                    'deal_title' => 'required |unique:deal_master',
                    // 'uploadimg_hidden'=>'required',
                    'start_date' => 'required',
                    'end_date' => 'required',


                ]);
            } else {
                $validator = Validator::make($input, [
                    'deal_title' => 'required',
                    // 'uploadimg_hidden'=>'required',
                    'start_date' => 'required',
                    'end_date' => 'required',

                ]);
            }
            if ($validator->fails()) {

                return response()->json('less Arguments OR Dealtitle Already Exists ');
            } else {
                $from1 = strtr($request->start_date, '/', '-');
                $start_date = date('Y-m-d', strtotime($from1));

                $from2 = strtr($request->end_date, '/', '-');
                $end_date = date('Y-m-d', strtotime($from2));

                $split = explode('.', $request->uploadimg_hidden, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

                $mp4 = $split[1];
                $is_video = "";
                if ($mp4 == "mp4") {
                    $is_video = "1";
                } else {
                    $is_video = "0";
                }

                $dealdata   =   Dealmodel::updateOrCreate(
                    ['deal_id' => $catid],
                    [
                        'deal_title'       =>   $request->deal_title,
                        'upload_img' => $request->uploadimg_hidden,
                        'is_video' => $is_video,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'user_id' => $user_id,

                    ]

                );




                if ($catid > 0) {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Deal Master Module';
                    $Logmodel->operation_name = 'Edit';
                    $Logmodel->reference_id = $catid;
                    $Logmodel->table_name = 'deal_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                } else {
                    $Logmodel = new Logmodel;

                    $Logmodel->module_name = 'Deal Master Module';
                    $Logmodel->operation_name = 'Insert';
                    $Logmodel->reference_id = $dealdata->deal_id;
                    $Logmodel->table_name = 'deal_master';
                    $Logmodel->user_id = $user_id;
                    $Logmodel->save();
                }


                return response()->json(['data' => $dealdata]);
            }
        } else {
            return Response::json(['msg' => 'Record Not Found']);
        }
    }


    //for deleting through api
    public function destroy($id)
    {

        $user_id = Session::get('login_id');
        $customer = Dealmodel::where('deal_id', $id)->delete();
        if ($customer > 0) {
            $Logmodel = new Logmodel;

            $Logmodel->module_name = 'Deal Master Module';
            $Logmodel->operation_name = 'Delete';
            $Logmodel->reference_id = $id;
            $Logmodel->table_name = 'deal_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
            return Response::json(['msg' => 'Delete Deal  Successfully',]);
        } else {
            return Response::json(['msg' => 'Delete Deal  Not Found Successfully',]);
        }
    }

    public function deals_api(Request $request)
    {
        $date = date("Y-m-d H:i:s");

        $from = date('Y-m-d H:i:s'); //should be course_date

        $to1 = strtr($request->to, '/', '-');
        // $to = date('Y-m-d H:i:s', strtotime($to1)); //should be course_date
        $to = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));

        $data = DB::table('deal_master')
            ->select('deal_master.*')
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->get();
        $result = array();



        foreach ($data as $val) {
            $video = "";
            $desc = "";
            $is_video = $val->is_video;
            if ($is_video == 0) {
                $video = "No";
            } else {
                $video = "Yes";
            }

            $result[] = array(
                'deal_id' => $val->deal_id,
                'title' => $val->deal_title,
                'image_video_url' =>  $val->upload_img,
                'is_video' => $video,


            );
        }


        return response()->json($result);
    }
}
