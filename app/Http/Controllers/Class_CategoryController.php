<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classcategorymodel;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;

class Class_CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('class_category');
        }


    }
    public function store(Request $request) //For insert or Update Record Of Package Master --
    {

        $user_id = $request->session()->get('login_id');
        $catid = $request->save_update;

        $input = $request->all();
        if ($catid == "") {
            $validator = Validator::make($input, [
                'classcategory_name' => 'required',
                'statusinfo' => 'required',

            ]);
        } else {
            $validator = Validator::make($input, [
                'classcategory_name' => 'required',
                'statusinfo' => 'required',

            ]);
        }
        if ($validator->fails()) {

            return response()->json('less Arguments OR Class Category Already Exists ');
        } else {
            if ($catid > 0) {
                $data = DB::table('classcategory_master')->where('classcategory_name', $request->classcategory_name)->where('classcategory_id', '!=', $catid)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('100');
                } {
                    $classcategory   =   Classcategorymodel::updateOrCreate(
                        ['classcategory_id' => $catid],
                        [
                            'classcategory_name'       =>   $request->classcategory_name,
                            'category_description'        =>   $request->category_description,
                            'status' => $request->statusinfo,
                            'user_id' => $user_id,

                        ]

                    );




                    if ($catid > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $catid;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $classcategory->classcategory_id;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data' => $classcategory]);
                }
            } else {
                $data = DB::table('classcategory_master')->where('classcategory_name', $request->classcategory_name)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('100');
                } else {

                    $classcategory   =   Classcategorymodel::updateOrCreate(
                        ['classcategory_id' => $catid],
                        [
                            'classcategory_name'       =>   $request->classcategory_name,
                            'category_description'        =>   $request->category_description,
                            'status' => $request->statusinfo,
                            'user_id' => $user_id,

                        ]

                    );




                    if ($catid > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $catid;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $classcategory->classcategory_id;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data' => $classcategory]);
                }
            }
        }
    }
    //for cheching Category Exist Or not
    public function checkclasscategory($catname)
    {
        $data = DB::table('classcategory_master')->where('classcategory_name', $catname)->get();
        $count = count($data);

        return response()->json($count);
    }
    public function editcheckclasscategory($catname, $id)
    {
        $data = DB::table('classcategory_master')->where('classcategory_name', $catname)->where('classcategory_id', '!=', $id)->get();
        $count = count($data);

        return response()->json($count);
    }

    //for getting all category---
    public function getall_classcategory()
    {
        $data = DB::table('classcategory_master')
            ->select('classcategory_master.*')
            ->orderBy('classcategory_id', 'DESC')
            ->get();

        return response()->json($data);
    }
    //for deleting category
    public function deletecategory($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Class Category Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'classcategory_master';
        $Logmodel->user_id = $user_id;
        // $Logmodel->table_name = 'package_master';
        $Logmodel->save();
        $customer = Classcategorymodel::where('classcategory_id', $id)->delete();
        return Response::json($customer);
    }
    //for gettting single class
    public function getsingleclasscategory($id)
    {
        $data = DB::table('classcategory_master')
            ->select('classcategory_master.*')
            ->where('classcategory_id', $id)
            ->get();
        $count = count($data);
        if ($count > 0) {
            return response()->json($data);
        } else {
            return response()->json(['msg' => 'Class Category Not Found']);
        }
    }
    //for deleting through api
    public function destroy($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name = 'Class Category Module';
        $Logmodel->operation_name = 'Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'classcategory_master';
        $Logmodel->user_id = $user_id;
        // $Logmodel->table_name = 'package_master';
        $Logmodel->save();
        $customer = Classcategorymodel::where('classcategory_id', $id)->delete();
        if ($customer > 0) {
            return Response::json(['msg' => 'Delete Class Category  Successfully',]);
        } else {
            return Response::json(['msg' => 'Delete Class Category Not Successfully',]);
        }
    }
    public function update(Request $request, $id)
    {
        $catid = $id;
        $user_id = $request->session()->get('login_id');

        $data = DB::table('classcategory_master')
            ->select('classcategory_master.*')
            ->where('classcategory_id', $catid)
            ->get();
        $count = count($data);
        if ($count > 0) {

            $input = $request->all();
            if ($catid == "") {
                $validator = Validator::make($input, [
                    'classcategory_name' => 'required|unique:classcategory_master',
                    'statusinfo' => 'required',

                ]);
            } else {
                $validator = Validator::make($input, [
                    'classcategory_name' => 'required',
                    'statusinfo' => 'required',

                ]);
            }
            if ($validator->fails()) {

                return response()->json('less Arguments OR Class Category Already Exists ');
            } else {
                $data = DB::table('classcategory_master')->where('classcategory_name', $request->classcategory_name)->where('classcategory_id', '!=', $catid)->get();
                $count = count($data);
                if ($count > 0) {
                    return response()->json('100');
                } {

                    $classcategory   =   Classcategorymodel::updateOrCreate(
                        ['classcategory_id' => $catid],
                        [
                            'classcategory_name'       =>   $request->classcategory_name,
                            'category_description'        =>   $request->category_description,
                            'status' => $request->statusinfo,
                            'user_id' => $user_id,

                        ]

                    );




                    if ($catid > 0) {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Edit';
                        $Logmodel->reference_id = $catid;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    } else {
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name = 'Class Category Module';
                        $Logmodel->operation_name = 'Insert';
                        $Logmodel->reference_id = $classcategory->classcategory_id;
                        $Logmodel->table_name = 'classcategory_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data' => $classcategory]);
                }
            }
        } else {
            return response()->json(['msg' => 'Class Category Not Founnd']);
        }
    }

    public function categorychangestatus($id, $status)
    {

        $user_id = Session::get('login_id');

        $data1 = DB::table('class_master')
            ->select('class_master.*')
            ->where('class_category', $id)
            ->where('status', 1)
            ->get();

        $count = count($data1);
        if ($count > 0) {
            return Response::json('100');
        } else {
            $Logmodel = new Logmodel;

            $Logmodel->module_name = 'Class Category Module';
            $Logmodel->operation_name = 'Change Status';
            $Logmodel->reference_id = $id;
            $Logmodel->table_name = 'classcategory_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();

            $customer = DB::update('update classcategory_master set status = ? where classcategory_id = ?', [$status, $id]);
            return Response::json($customer);
        }
    }

    //for getting all category---
    public function getdesibleall_classcategory()
    {
        $result = array();
        $data = DB::table('classcategory_master')
            ->select('classcategory_master.*')
            ->orderBy('classcategory_id', 'DESC')
            ->get();

        $count = count($data);

        if ($count > 0) {
            foreach ($data as $categorydata) {
                $classcategory_id = $categorydata->classcategory_id;
                $classcategory_name = $categorydata->classcategory_name;
                $category_description = $categorydata->category_description;
                $status = $categorydata->status;
                $active = "";
                if ($classcategory_id > 0) {
                    $data2 = DB::table('class_master')
                        ->select('class_master.*')
                        ->where('class_category', $classcategory_id)
                        ->get();
                    $count1 = count($data2);
                    if ($count1 > 0) {
                        $active = 1;
                    } else {
                        $active = 0;
                    }
                }
                $result[] = array(
                    'classcategory_id' => $classcategory_id,
                    'classcategory_name' => $classcategory_name,
                    'category_description' => $category_description,
                    'status' => $status,
                    'active' => $active,
                );
            }
        }

        return response()->json($result);
    }

    //for getting all category---
    public function getall_classcategory2()
    {
        $today = date("Y-m-d");
        // $data = DB::table('classcategory_master')
        //    ->select('classcategory_master.*')
        //     ->orderBy('classcategory_id', 'DESC')
        //     ->get();

        $data = DB::table('classcategory_master')
            ->select(DB::raw('DATE(class_sechedule_master.class_schedule) as formatted_date'))
            ->join('class_master', 'class_master.class_category', '=', 'classcategory_master.classcategory_id')
            ->join('class_sechedule_master', 'class_sechedule_master.classsechedule_name', '=', 'class_master.class_id')
            ->where('class_master.status', 1)
            ->where('class_sechedule_master.status', 1)
            ->where('class_sechedule_master.class_schedule', '>=', $today)
            ->distinct('formatted_date')
            ->orderBy('class_sechedule_master.class_schedule', 'ASC')
            ->get();

        $result = array();

        foreach ($data as $val) {
            $result[] = array(
                'date' => $val->formatted_date,

            );
        }


        return response()->json($result);
    }



    public function category_wise(Request $request)
    {
        $id = $request->id;
        $result = array();
        $result2 = array();
        $result3 = array();
        $data = DB::table('classcategory_master')
            ->select('classcategory_master.*', 'class_master.class_description', 'class_master.class_name as classname', 'class_master.class_id', DB::raw('DATE(class_sechedule_master.class_schedule) as formatted_date'))
            ->join('class_master', 'class_master.class_category', '=', 'classcategory_master.classcategory_id')
            ->join('class_sechedule_master', 'class_sechedule_master.classsechedule_name', '=', 'class_master.class_id')
            ->where('classcategory_master.classcategory_id', $id)
            ->where('class_master.status', 1)
            ->where('class_sechedule_master.status', 1)

            ->groupBy('formatted_date')
            ->orderBy('class_sechedule_master.class_schedule', 'ASC')
            ->get();

        $date = "";
        // $result=array();

        foreach ($data as $val) {

            $date = $val->formatted_date;


            $result[] = array('date' => $date);


            $data4 = DB::table('class_sechedule_master')
                ->select('class_sechedule_master.*',  'instuctor_master.instructor_name')
                ->join('instuctor_master', 'instuctor_master.instructorid', '=', 'class_sechedule_master.instructor')
                ->whereDate('class_sechedule_master.class_schedule', $date)
                ->get();



            foreach ($data4 as $val4) {

                $schedule_id = $val4->classsechedule_id;

                $data3 = DB::table('booking_table')
                    ->select('booking_table.*')
                    ->where('booking_table.is_cancelled', 1)
                    ->where('booking_table.class_schedule_id', $schedule_id)
                    ->get()->count();
                $available = intval($val4->max_vacancy) - intval($data3);

                $result2[] = array(
                    'id' => $val4->classsechedule_id,
                    'class_schedule' => $val4->class_schedule,
                    'class_name' => $val->classname,
                    'instructor_name' => $val4->instructor_name,
                    'duration' => $val4->class_duration,
                    'vacancy' => $val4->max_vacancy,
                    'class_description' => $val->class_description,
                    'min_cancelation' => $val4->min_cancelation,
                    'min_booking' => $val4->min_booking,
                    'status' => $val4->status,
                    'available' => $available,
                );

                // $result3=array('date'=>$date,'data'=>$result2);
                // $result=['date'=>$date,'data'=>$result3];


            }

            array_push($result, $result2);
            //  return response()->json([$date => $result]);

            //$result=array('date'=>$date,$result2);
            // $result=$result2;


        }

        return response()->json($result);
        //   return response()->json($result);
        //  return response()->json([$date => $result]);
    }
}
