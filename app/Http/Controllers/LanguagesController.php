<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;

class LanguagesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('language');
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
