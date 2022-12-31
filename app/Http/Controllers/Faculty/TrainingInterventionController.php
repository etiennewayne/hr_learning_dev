<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\LearningDevelopment;

class TrainingInterventionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        $user = Auth::user();
        return view('faculty.trainings-interventions')
            ->with('user', $user);
    }


    public function getLearningTrainings(Request $req){
        $user = Auth::user();

        $data = LearningDevelopment::where('user_id', $user->user_id)
            ->get();
            
        return $data;
    }


    public function store(Request $req){
        $user = Auth::user();

        $dateFrom = date("Y-m-d", strtotime($req->date_from)); //convert to date format UNIX
        $dateTo = date("Y-m-d", strtotime($req->date_to)); //convert to date format UNIX

        return $req;


        $file = $req->file('file');
        $file_location = '';
        if($file){
            //check the file and delete to update
            // if(Storage::exists('public/certificates/' .$data->file)) {
            //     Storage::delete('public/certificates/' . $data->bhouse_img_path);
            // }
            $filePath = $file->store('public/certificates'); //get path of the file
            $filePathArray = explode('/', $filePath); //split into array using /
            $file_location = $filePathArray[2];
        }

        $data = LearningDevelopment::created([
            'user_id' => $user->user_id,
            'title_learning_dev' => $req->title_learning_dev,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'no_hourse' => $req->no_hourse,
            'type_ld' => $req->type_ld,
            'sponsored_by' => $req->sponsored_by,
            'attach_path' => $file_location,
        ]);


        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function destroy($id){
        $data = LearningDevelopment::find($id);
        if(Storage::exists('public/certificates/' .$data->img_path)) {
            Storage::delete('public/certificates/' . $data->img_path);
        }
        LearningDevelopment::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }


}
