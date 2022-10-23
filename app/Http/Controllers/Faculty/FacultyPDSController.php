<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Citizenship;
use App\Models\CivilStatus;
use Illuminate\Http\Request;

class FacultyPDSController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $civils = CivilStatus::all();
        $citizenships = Citizenship::orderBy('citizenship', 'asc')->get();

        return view('faculty.faculty-pds')
            ->with('civils', $civils)
            ->with('citizenships', $citizenships);
    }


}
