<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassBookingController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/');
        } else {
            return view('class_booking');
        }


    }
}
