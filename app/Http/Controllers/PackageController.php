<?php

namespace App\Http\Controllers;
use App\Packagemodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('package');
        }

    }


    public function store(Request $request)//For insert or Update Record Of Package Master --
    {

        $user_id = Session::get('login_id');
        $packege_id = $request->save_update;

        $input = $request->all();

        if($packege_id==""){
        $validator = Validator::make($input, [
            'package_name' => 'required',
            'package_point' => 'required',
            'package_price'=>'required',
            'statusinfo'=>'required',

            ]);
        }else{
            $validator = Validator::make($input, [
                'package_name' => 'required',
                'package_point' => 'required',
                'package_price'=>'required',
                'statusinfo'=>'required',

                ]);
        }
            if($validator->fails()){

                return response()->json('less Arguments OR Package Name Already Exists ');
            }else{

                if($packege_id >0){
                    $data= DB::table('package_master')->where('package_name',$request->package_name)->where('packege_id','!=',$packege_id)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $package   =   Packagemodel::updateOrCreate(
                            ['packege_id' => $packege_id],
                            [
                                'package_name'       =>   $request->package_name,
                                'package_point'        =>   $request->package_point,
                                'package_price'        =>   $request->package_price,
                                'status'=>$request->statusinfo,
                                'user_id' => $user_id,

                            ]

                        );




                        if( $packege_id >0){
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Package Module' ;
                            $Logmodel->operation_name ='Edit';
                            $Logmodel->reference_id = $packege_id;
                            $Logmodel->table_name = 'package_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();

                        }else{
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Package Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $package->packege_id;
                            $Logmodel->table_name = 'package_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                        }


                        return response()->json(['data'=> $package]);
                    }


                }else{

                    $data= DB::table('package_master')->where('package_name',$request->package_name)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                  $package   =   Packagemodel::updateOrCreate(
            ['packege_id' => $packege_id],
            [
                'package_name'       =>   $request->package_name,
                'package_point'        =>   $request->package_point,
                'package_price'        =>   $request->package_price,
                'status'=>$request->statusinfo,
                'user_id' => $user_id,

            ]

        );




        if( $packege_id >0){
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Package Module' ;
            $Logmodel->operation_name ='Edit';
            $Logmodel->reference_id = $packege_id;
            $Logmodel->table_name = 'package_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();

        }else{
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Package Module' ;
            $Logmodel->operation_name ='Insert';
            $Logmodel->reference_id = $package->packege_id;
            $Logmodel->table_name = 'package_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
        }


        return response()->json(['data'=> $package]);
    }
    }
    }

        //return Response::json($package);
    }
    public function get_packages(){
        $data = DB::table('package_master')
            ->select('package_master.*')
            ->orderBy('packege_id', 'DESC')
            ->get();

            return Response::json($data);
    }
    public function deletepackage($id){
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Package Module' ;
        $Logmodel->operation_name ='Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'package_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        $customer = Packagemodel::where('packege_id', $id)->delete();
        return Response::json($customer);
    }
    public function changestatus($id,$status){
        $user_id = Session::get('login_id');
       // dd($id,$status);
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Package Module' ;
        $Logmodel->operation_name ='Change Status';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'package_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();

        $customer = DB::update('update package_master set status = ? where packege_id = ?',[$status,$id]);
        return Response::json($customer);
    }
    public function update(Request $request, $id)
    {
        $packege_id = $id;
        $user_id = Session::get('login_id');
        $input = $request->all();

        $validator = Validator::make($input, [
            'package_name' => 'required',
            'package_point' => 'required',
            'package_price'=>'required',
            'statusinfo'=>'required',

            ]);
            if($validator->fails()){

                return response()->json('less Arguments OR Package Name Already Exists ');
            }else{

                $data= DB::table('package_master')->where('package_name',$request->package_name)->where('packege_id','!=',$packege_id)->get();
                $count=count($data);
                if($count >0){
                    return response()->json(['data'=>'100','msg'=>'package name Exists']);
                }else{
                    $package   =   Packagemodel::updateOrCreate(
                        ['packege_id' => $packege_id],
                        [
                            'package_name'       =>   $request->package_name,
                            'package_point'        =>   $request->package_point,
                            'package_price'        =>   $request->package_price,
                            'status'=>$request->statusinfo,
                            'user_id' => $user_id,

                        ]

                    );




                    if( $packege_id >0){
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name ='Package Module' ;
                        $Logmodel->operation_name ='Edit';
                        $Logmodel->reference_id = $packege_id;
                        $Logmodel->table_name = 'package_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();

                    }else{
                        $Logmodel = new Logmodel;

                        $Logmodel->module_name ='Package Module' ;
                        $Logmodel->operation_name ='Insert';
                        $Logmodel->reference_id = $package->packege_id;
                        $Logmodel->table_name = 'package_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                    }


                    return response()->json(['data'=> $package]);
                }

    }


    }
    public function getpackage($id){
        $data = DB::table('package_master')
        ->select('package_master.*')
        ->where('packege_id',$id)
        ->where('status',1)
        ->get();
        $count=count($data);
        if($count >0){
            return Response::json($data);
        }else{
            return Response::json(['msg'=>'Data Not Found']);
        }

    }
    public function destroy($id)
    {
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Package Module' ;
        $Logmodel->operation_name ='Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'package_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        $customer = Packagemodel::where('packege_id', $id)->delete();
        if($customer >0){
            return Response::json(['msg'=>'Delete Record  Successfully',]);
        }else{
            return Response::json(['msg'=>'Delete Record Not Successfully',]);
        }


    }
    public function chackpackagename($package){
        $data= DB::table('package_master')->where('package_name',$package)->get();
        $count=count($data);

        return response()->json($count);
    }
    public function editchackpackagename($package,$id){
        $data= DB::table('package_master')->where('package_name',$package)->where('packege_id','!=',$id)->get();
        $count=count($data);

        return response()->json($count);
    }
}
