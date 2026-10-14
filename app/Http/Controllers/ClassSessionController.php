<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassSessionController extends Controller
{
    //
    public function index()
    {
        return view('class_sessions');
    }
}
