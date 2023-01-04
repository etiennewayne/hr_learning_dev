<?php

namespace App\Http\Controllers\Hrld;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeminarPost;


class HrldSeminarPostController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('hrld.seminar-posts');
    }


    public function getSeminars(){
        $data = SeminarPost::orderBy('seminar_post_id', 'desc')->get();
        return $data;
    }


    public function store(Request $req){
        
 
        $file = $req->file('file');
        $file_location = '';
        
        if($file){
            //check the file and delete to update
            // if(Storage::exists('public/certificates/' .$data->file)) {
            //     Storage::delete('public/certificates/' . $data->bhouse_img_path);
            // }

            $filePath = $file->store('public/seminars'); //get path of the file
            $filePathArray = explode('/', $filePath); //split into array using /
            $file_location = $filePathArray[2];
        }

        $data = SeminarPost::create([
            'description' => $req->desc,
            'img_path' => $file_location,
            'date_posted' => date('Y-m-d')
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
