<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use App\Logmodel;
use App\Classmastermodel;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
class ClassController extends Controller
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
            return view('class',$data);
        }



    }
    //for getting all category
    public function getall_category(){

        $data = DB::table('classcategory_master')
        ->select('classcategory_master.*')
        ->where('status',1)
        ->get();
        return response()->json($data);

    }

    public function store(Request $request)//For insert or Update Record Of class Master --
    {
        $user_id = Session::get('login_id');

        $catid = $request->save_update;

        $input = $request->all();
        if($catid ==""){
        $validator = Validator::make($input, [
            'class_name' => 'required',

            'class_category'=>'required',
            'statusinfo'=>'required',

            ]);
        }else{
            $validator = Validator::make($input, [
                'class_name' => 'required',

                'class_category'=>'required',
                'statusinfo'=>'required',

                ]);
        }
            if($validator->fails()){

                return response()->json('less Arguments OR Class Category Already Exists ');
            }else{
                if($catid >0 ){
                    $data= DB::table('class_master')->where('class_name',$request->class_name)->where('class_id','!=',$catid)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $classcategory   =   Classmastermodel::updateOrCreate(
                            ['class_id' => $catid],
                            [
                                'class_name'       =>   $request->class_name,
                                'class_category'       =>   $request->class_category,
                                'class_description'       =>   $request->class_description,
                                'status'=>$request->statusinfo,
                                'user_id'=>$user_id,

                            ]

                        );




                        if( $catid >0){
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Class master Module' ;
                            $Logmodel->operation_name ='Edit';
                            $Logmodel->reference_id = $catid;
                            $Logmodel->table_name = 'class_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();

                        }else{
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Class master Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $classcategory->class_id;
                            $Logmodel->table_name = 'class_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                        }


                        return response()->json(['data'=> $classcategory]);
                    }
                }else{
                    $data= DB::table('class_master')->where('class_name',$request->class_name)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $classcategory   =   Classmastermodel::updateOrCreate(
                            ['class_id' => $catid],
                            [
                                'class_name'       =>   $request->class_name,
                                'class_category'       =>   $request->class_category,
                                'class_description'       =>   $request->class_description,
                                'status'=>$request->statusinfo,
                                'user_id'=>$user_id,

                            ]

                        );




                        if( $catid >0){
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Class master Module' ;
                            $Logmodel->operation_name ='Edit';
                            $Logmodel->reference_id = $catid;
                            $Logmodel->table_name = 'class_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();

                        }else{
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Class master Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $classcategory->class_id;
                            $Logmodel->table_name = 'class_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                        }


                        return response()->json(['data'=> $classcategory]);
                    }
                }


    }


    }
    public function getallclass(){
        $data = DB::table('class_master')

           ->join('classcategory_master', 'classcategory_master.classcategory_id', '=', 'class_master.class_category')
            ->select('class_master.*', 'classcategory_master.classcategory_name as classcategory')
            ->orderBy('class_master.class_id', 'DESC')
            ->get();

           return response()->json( $data);

    }

    //forsingle classs
    public function getsingleclass($id){
        $data = DB::table('class_master')

           ->join('classcategory_master', 'classcategory_master.classcategory_id', '=', 'class_master.class_category')
            ->where('class_id',$id)
           ->select('class_master.*', 'classcategory_master.classcategory_name as classcategory')
           ->get();
        $count=count($data);
           if($count >0){
            return response()->json( $data);
           }else{
            return response()->json(['msg'=>'Data Not Found']);
           }


    }
    public function deleteclass($id){
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Class master Module' ;
        $Logmodel->operation_name ='Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'class_master';
        $Logmodel->user_id =$user_id;
        $Logmodel->save();
        $customer = Classmastermodel::where('class_id', $id)->delete();
        return Response::json($customer);
    }

      //for change status
      public function classchangestatus($id,$status){

        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Class master Module' ;
        $Logmodel->operation_name ='Change Status';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'class_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();

        $customer = DB::update('update class_master set status = ? where class_id = ?',[$status,$id]);
        return Response::json($customer);
    }
     //for update
     public function update(Request $request, $id)
     {
        $user_id = Session::get('login_id');
        $catid = $id;
        $data = DB::table('class_master')
         ->select('class_master.*')
         ->where('class_id',$catid)
         ->get();
         $count=count($data);
         if($count >0){


        $input = $request->all();
        if($catid ==""){
        $validator = Validator::make($input, [
            'class_name' => 'required|unique:class_master',

            'class_category'=>'required',
            'statusinfo'=>'required',

            ]);
        }else{
            $validator = Validator::make($input, [
                'class_name' => 'required',

                'class_category'=>'required',
                'statusinfo'=>'required',

                ]);
        }
            if($validator->fails()){

                return response()->json('less Arguments OR Class Category Already Exists ');
            }else{
                $data= DB::table('class_master')->where('class_name',$request->class_name)->where('class_id','!=',$catid)->get();
                $count=count($data);
                if($count >0){
                    return response()->json(['data'=>'100','msg'=>'Class Name Already Exists']);
                }else{

        $classcategory   =   Classmastermodel::updateOrCreate(
            ['class_id' => $catid],
            [
                'class_name'       =>   $request->class_name,
                'class_category'       =>   $request->class_category,
                'class_description'       =>   $request->class_description,
                'status'=>$request->statusinfo,
                'user_id'=>$user_id,

            ]

        );




        if( $catid >0){
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Class master Module' ;
            $Logmodel->operation_name ='Edit';
            $Logmodel->reference_id = $catid;
            $Logmodel->table_name = 'class_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();

        }else{
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Class master Module' ;
            $Logmodel->operation_name ='Insert';
            $Logmodel->reference_id = $classcategory->class_id;
            $Logmodel->table_name = 'class_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
        }


        return response()->json(['data'=> $classcategory]);
    }
    }
     }else{
        return response()->json(['msg'=>'Record Not Found']);
     }
    }

     //for deleting through api
     public function destroy($id)
     {
        $user_id = Session::get('login_id');
         $customer = Classmastermodel::where('class_id', $id)->delete();
         if($customer >0){
            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Class Master Module' ;
            $Logmodel->operation_name ='Delete';
            $Logmodel->reference_id = $id;
            $Logmodel->table_name = 'class_master';
            $Logmodel->user_id =$user_id;
            $Logmodel->save();
             return Response::json(['msg'=>'Delete Class  Successfully',]);
         }else{
             return Response::json(['msg'=>'Delete Class  Not Found Successfully',]);
         }


     }

      //for cheching Category Exist Or not
    public function checkclassexist($name){
        $data= DB::table('class_master')->where('class_name',$name)->get();
        $count=count($data);

        return response()->json($count);
    }
    public function editcheckclassexist($name,$id){
        $data= DB::table('class_master')->where('class_name',$name)->where('class_id','!=',$id)->get();
        $count=count($data);

        return response()->json($count);
    }

}
