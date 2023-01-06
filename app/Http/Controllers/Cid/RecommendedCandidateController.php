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
        //->whereRaw('(select specialization) like ?', [$req->sspecialization . '%'])

        $queryBuilder = DB::table('users as a')
            ->where('role', 'FACULTY')
            ->select('a.user_id', 'a.lname', 'a.fname', 'a.mname',
                DB::raw('(select count(*) from learning_developments where user_id = a.user_id) as no_seminars'),
                DB::raw('IFNULL((SELECT GROUP_CONCAT(skill_hobbies SEPARATOR ", ") FROM other_informations WHERE user_id = a.user_id),"") as specialization'),

                'a.role', 'a.suffix', 'a.sex', 'a.civil_status')
            ->where('a.lname', 'like', $req->lname . '%');
        //return $queryBuilder->toSql();

        //$data = DB::raw('select * from ('.$queryBuilder.') as tbl1')->get(); 

        $data = DB::table($queryBuilder)
                
                ->where('specialization', 'like', $req->specialization . '%')
                ->orderBy('no_seminars', 'asc')
                ->get();

        return $data;
    }


}
