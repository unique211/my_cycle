<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Session;
use Illuminate\Support\Facades\DB;
use Redirect;

class LanguagesController extends Controller
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
            return view('language',$data);
        }

    }

    public function change_lang(Request $request)
    {


        if (!\Session::has('locale')) {
            \Session::put('locale', $request->languages);
        } else {
            session(['locale' => $request->languages]);
        }

        // dd($request->languages);
        return Redirect::back();
    }
}
