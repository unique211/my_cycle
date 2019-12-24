<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use App\Logmodel;
use App\Roommastermodel;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
class RoomController extends Controller
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
            return view('room',$data);
        }

    }


    public function store(Request $request)//For insert or Update Record Of Room Master --
    {

        $user_id = Session::get('login_id');
        $catid = $request->save_update;

        $input = $request->all();
        if($catid ==""){
        $validator = Validator::make($input, [
            'room' => 'required',
            'statusinfo'=>'required',

            ]);
        }else{
            $validator = Validator::make($input, [
                'room' => 'required',
                'statusinfo'=>'required',

                ]);
        }
            if($validator->fails()){

                return response()->json('less Arguments OR Class Category Already Exists ');
            }else{
                if( $catid >0){
                    $data= DB::table('room_master')->where('room',$request->room)->where('rooom_id', '!=',$catid)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $classcategory   =   Roommastermodel::updateOrCreate(
                            ['rooom_id' => $catid],
                            [
                                'room'       =>   $request->room,
                                'status'=>$request->statusinfo,
                                'user_id'=>$user_id,

                            ]

                        );




                        if( $catid >0){
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Room master Module' ;
                            $Logmodel->operation_name ='Edit';
                            $Logmodel->reference_id = $catid;
                            $Logmodel->table_name = 'room_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();

                        }else{
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Room master Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $classcategory->rooom_id;
                            $Logmodel->table_name = 'room_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                        }


                        return response()->json(['data'=> $classcategory]);
                    }

                }else{
                    $data= DB::table('room_master')->where('room',$request->room)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $classcategory   =   Roommastermodel::updateOrCreate(
                            ['rooom_id' => $catid],
                            [
                                'room'       =>   $request->room,
                                'status'=>$request->statusinfo,
                                'user_id'=>$user_id,

                            ]

                        );

                        if( $catid >0){
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Room master Module' ;
                            $Logmodel->operation_name ='Edit';
                            $Logmodel->reference_id = $catid;
                            $Logmodel->table_name = 'room_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();

                        }else{
                            $Logmodel = new Logmodel;

                            $Logmodel->module_name ='Room master Module' ;
                            $Logmodel->operation_name ='Insert';
                            $Logmodel->reference_id = $classcategory->rooom_id;
                            $Logmodel->table_name = 'room_master';
                            $Logmodel->user_id = $user_id;
                            $Logmodel->save();
                        }


                        return response()->json(['data'=> $classcategory]);
                    }
                }



    }

        //return Response::json($package);
    }

      //for cheching Room Exist Or not
      public function checkroomexist($catname){
        $data= DB::table('room_master')->where('room',$catname)->get();
        $count=count($data);

        return response()->json($count);
    }
    public function editcheckroomexist($catname,$id){
        $data= DB::table('room_master')->where('room',$catname)->where('rooom_id !=',$id)->get();
        $count=count($data);

        return response()->json($count);
    }
    public function getallroom(){
        $data = DB::table('room_master')
        ->select('room_master.*')
        ->get();

        return response()->json($data);
    }

    //for gettting single class
    public function getsingleroom($id){
        $data = DB::table('room_master')
        ->select('room_master.*')
        ->where('rooom_id',$id)
        ->get();
        $count=count($data);
        if($count >0){
            return response()->json($data);
        }else{
            return response()->json(['msg'=>'Room Not Found']);
        }


    }
    public function deleteroom($id){
        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Room master Module' ;
        $Logmodel->operation_name ='Delete';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'room_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();
        $customer = Roommastermodel::where('rooom_id', $id)->delete();
        return Response::json($customer);
    }

     //for deleting through api
     public function destroy($id)
     {
        $user_id = Session::get('login_id');
         $Logmodel = new Logmodel;

         $Logmodel->module_name ='Room Module' ;
         $Logmodel->operation_name ='Delete';
         $Logmodel->reference_id = $id;
         $Logmodel->table_name = 'room_master';
         $Logmodel->user_id = $user_id;
         $Logmodel->save();
         $customer = Roommastermodel::where('rooom_id', $id)->delete();
         if($customer >0){
             return Response::json(['msg'=>'Delete Room  Successfully',]);
         }else{
             return Response::json(['msg'=>'Delete Room  Not Successfully',]);
         }


     }
     //for update
     public function update(Request $request, $id)
     {
         $catid = $id;
         $user_id = Session::get('login_id');
         $data = DB::table('room_master')
         ->select('room_master.*')
         ->where('rooom_id',$catid)
         ->get();
         $count=count($data);
         if($count >0){
         $input = $request->all();
         if($catid ==""){
         $validator = Validator::make($input, [
             'room' => 'required|unique:room_master',
             'statusinfo'=>'required',

             ]);
         }else{
             $validator = Validator::make($input, [
                 'room' => 'required',
                 'statusinfo'=>'required',

                 ]);
         }
             if($validator->fails()){

                 return response()->json('less Arguments OR Class Category Already Exists ');
             }else{
                $data= DB::table('room_master')->where('room',$request->room)->where('rooom_id', '!=',$catid)->get();
                $count=count($data);
                if($count >0){
                    return response()->json(['data'=>'100','msg'=>'Room Already Exists']);
                }else{

         $classcategory   =   Roommastermodel::updateOrCreate(
             ['rooom_id' => $catid],
             [
                 'room'       =>   $request->room,
                 'status'=>$request->statusinfo,
                 'user_id'=>$user_id,

             ]

         );




         if( $catid >0){
             $Logmodel = new Logmodel;

             $Logmodel->module_name ='Room master Module' ;
             $Logmodel->operation_name ='Edit';
             $Logmodel->reference_id = $catid;
             $Logmodel->table_name = 'room_master';
             $Logmodel->user_id = $user_id;
             $Logmodel->save();

         }else{
             $Logmodel = new Logmodel;

             $Logmodel->module_name ='Room master Module' ;
             $Logmodel->operation_name ='Insert';
             $Logmodel->reference_id = $classcategory->rooom_id;
             $Logmodel->table_name = 'room_master';
             $Logmodel->user_id = $user_id;
             $Logmodel->save();
         }


         return response()->json(['data'=> $classcategory]);
        }
     }

        }else{
            return response()->json(['msg'=>'Not Found Record']);
        }
    }
    //for change status
    public function roomchangestatus($id,$status){

        $user_id = Session::get('login_id');
        $Logmodel = new Logmodel;

        $Logmodel->module_name ='Room master Module' ;
        $Logmodel->operation_name ='Change Status';
        $Logmodel->reference_id = $id;
        $Logmodel->table_name = 'room_master';
        $Logmodel->user_id = $user_id;
        $Logmodel->save();

        $customer = DB::update('update room_master set status = ? where rooom_id = ?',[$status,$id]);
        return Response::json($customer);
    }

    public function gethidedelallroom(){
        $result=array();
        $data = DB::table('room_master')
        ->select('room_master.*')
        ->orderBy('rooom_id','DESC')
        ->get();

        $count=count($data);
        if($count >0){
            foreach($data as $roomdata){
                $rooom_id=$roomdata->rooom_id;
                $room=$roomdata->room;
                $status=$roomdata->status;
                $active="";
               if($rooom_id >0){
                $data2 = DB::table('class_sechedule_master')
                ->select('class_sechedule_master.*')
                ->where('room_id',$rooom_id)
                ->get();
                $count2=count($data2);
                if($count2 >0){
                    $active=1;
                }else{
                    $active=0;
                }

               }
               $result[]=array(
                'rooom_id'=>$rooom_id,
                'room'=>$room,
                'status'=>$status,
                'active'=>$active,


               );
            }
        }

        return response()->json($result);
    }


}
