<?php

namespace App\Http\Controllers\Cid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendedCandidateController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
        $this->middleware('cid');
        
    }


    public function index(){
        return view('cid.recommended-candidate');
    }

    public function generateList(Request $req){

        $data = DB::table('users as a')
            ->where('role', 'FACULTY')
            ->select('a.user_id', 'a.lname', 'a.fname', 'a.mname', 'a.sex',
                DB::raw('(select count(*) from learning_developments where user_id = a.user_id) as no_seminars'),
                'a.role', 'a.suffix', 'a.sex', 'a.civil_status')
            ->orderBy('no_seminars', 'asc')
            ->get();

        return $data;
    }


}
