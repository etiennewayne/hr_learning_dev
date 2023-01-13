<?php

namespace App\Http\Controllers\Cid;

use App\Http\Controllers\Controller;
use App\Models\SeminarPost;
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
                ->where('specialization', 'like', '%' .$req->specialization . '%')
//                ->where('lname', 'like', '%' .$req->lname . '%')
//                ->where('fname', 'like', '%' .$req->fname . '%')
                ->orderBy('no_seminars', 'asc')
                ->get();
        return $data;
    }


    public function getSeminarSpecializationList(Request $req){
        $data = SeminarPost::where('title', 'like', $req->title . '%')
            ->whereDate('seminar_date', '>=', date('Y-m-d'))
            ->get();

        return $data;
    }


    public function store(Request $req){

        return $req;

        $data = RecommendedInfo::create([
            'seminar_post_id' => $req->seminar_post_id,
            'seminar_title' => $req->seminar_title,
            'list_information' => $req->list_information,
        ]);

        foreach($req->teachers as $item){
            RecommendedTeacher::create([
                'recommended_info_id' => $data->recommended_info,
                'teacher_id' => $data->teacher_id,
                'lname' => $data->lname,
                'fname' => $data->fname,
                'mname' => $data->mname,
            ]);
        }
       

        return response()->json([
            'status' => 'saved'
        ], 200);

    }


}
