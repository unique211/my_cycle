<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Membertypemodel;

use Illuminate\Support\Facades\DB;
use Redirect, Response;
use App\Logmodel;
use Validator;
use Session;
class MemberTypeController extends Controller
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
            return view('member_type',$data);
        }

    }


    public function store(Request $request)//For insert or Update Record Of Package Master --
    {

        $user_id = Session::get('login_id');
        $membertypeid = $request->save_update;

        $input = $request->all();

        $validator = Validator::make($input, [
            'member_type' => 'required',


            ]);

            if($validator->fails()){

                return response()->json('less Arguments');
            }else{
                if($membertypeid >0){
                    $data= DB::table('membertype_master')->where('member_type',$request->member_type)->where('membertype_id','!=',$membertypeid)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $package   =   Membertypemodel::updateOrCreate(
                            ['membertype_id' => $membertypeid],
                            [
                                'member_type'       =>   $request->member_type,
                                'user_id'       => $user_id,


                            ]

                        );

                        $Logmodel = new Logmodel;

                        $Logmodel->module_name ='Member Type Module' ;
                        $Logmodel->operation_name ='Edit';
                        $Logmodel->reference_id = $membertypeid;
                        $Logmodel->table_name = 'membertype_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                        return response()->json(['data'=> $package]);
                    }
                }else{
                    $data= DB::table('membertype_master')->where('member_type',$request->member_type)->get();
                    $count=count($data);
                    if($count >0){
                        return response()->json('100');
                    }else{
                        $package   =   Membertypemodel::updateOrCreate(
                            ['membertype_id' => $membertypeid],
                            [
                                'member_type'       =>   $request->member_type,
                                'user_id'       => $user_id,


                            ]

                        );

                        $Logmodel = new Logmodel;

                        $Logmodel->module_name ='Member Type Module' ;
                        $Logmodel->operation_name ='Insert';
                        $Logmodel->reference_id = $package->membertype_id;
                        $Logmodel->table_name = 'membertype_master';
                        $Logmodel->user_id = $user_id;
                        $Logmodel->save();
                        return response()->json(['data'=> $package]);
                    }
                }

            }



    }
    public function chackmemberexist($membertype){
        $data= DB::table('membertype_master')->where('member_type',$membertype)->get();
        $count=count($data);
        return response()->json($count);
    }




    public function update(Request $request, $id)
    {
        $membertypeid = $id;
        $user_id = Session::get('login_id');
        $data= DB::table('membertype_master')->where('member_type',$request->member_type)->where('membertype_id','!=',$membertypeid)->get();
        $count=count($data);
        if($count >0){
            return response()->json('100');
        }else{
            $package   =   Membertypemodel::updateOrCreate(
                ['membertype_id' => $membertypeid],
                [
                    'member_type'       =>   $request->member_type,
                    'user_id'       => $user_id,


                ]

            );

            $Logmodel = new Logmodel;

            $Logmodel->module_name ='Member Type Module' ;
            $Logmodel->operation_name ='Edit';
            $Logmodel->reference_id = $membertypeid;
            $Logmodel->table_name = 'membertype_master';
            $Logmodel->user_id = $user_id;
            $Logmodel->save();
            return response()->json(['data'=> $package]);
    }
}
public function getallmemberttype(){
    $data= DB::table('membertype_master')->get();
    return response()->json( $data);
}
public function deletemembertype($id){
    $user_id = Session::get('login_id');

    $Logmodel = new Logmodel;

    $Logmodel->module_name ='Member Type Module' ;
    $Logmodel->operation_name ='Delete';
    $Logmodel->reference_id = $id;
    $Logmodel->table_name = 'membertype_master';
    $Logmodel->user_id = $user_id;
    $Logmodel->save();

    $customer = Membertypemodel::where('membertype_id', $id)->delete();
    return response()->json( $customer);

}
public function destroy($id)
{

    $customer = Membertypemodel::where('membertype_id', $id)->delete();
    $user_id = Session::get('login_id');
    if($customer >0){
        $Logmodel = new Logmodel;

    $Logmodel->module_name ='Member Type Module' ;
    $Logmodel->operation_name ='Delete';
    $Logmodel->reference_id = $id;
    $Logmodel->table_name = 'membertype_master';
    $Logmodel->user_id = $user_id;
    $Logmodel->save();
        return Response::json(['msg'=>'Delete Record  Successfully']);
    }else{
        return Response::json(['msg'=>'Delete Record Not Successfully']);
    }


}
public function getsinglegmembertype($id){
    $data= DB::table('membertype_master')->where('membertype_id',$id)->get();
    return Response::json(['data'=>$data]);

}

public function checkuserid_member($userid)
{
    $profile = DB::table('link_relation_ship')->where('userid', $userid)->get();
    $count = count($profile);
    return Response::json($count);
}

}
