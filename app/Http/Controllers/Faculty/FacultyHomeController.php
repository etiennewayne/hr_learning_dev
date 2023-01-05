<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacultyHomeController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('faculty');
    }

    public function index(){
        return view('faculty.faculty-home');
    }



}
