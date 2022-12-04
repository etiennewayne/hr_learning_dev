<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Models\Appointment;
use App\Models\User;
use App\Models\DentistSchedule;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/get-dental-services', [App\Http\Controllers\Administrator\ServicesController::class, 'getDentalServices']);


Route::get('/get-open-dentists', function () {
    $dentists = User::where('role', 'DENTIST')
        ->orderBy('lname', 'asc')->get();
    return $dentists;
});

Route::get('/get-dentist-schedules/{id}', function ($id) {
    $schedules = DentistSchedule::with(['user'])
        ->whereHas('user', function($q) use ($id){
            $q->where('user_id', $id);
        })
        ->get();
    return $schedules;
});


Auth::routes([
    'login' => 'false'
]);

Route::get('/load-user', function(){
    if(Auth::check()){
        return Auth::user();
    }
});




Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sign-up', [App\Http\Controllers\SignUpController::class, 'index']);
Route::post('/sign-up', [App\Http\Controllers\SignUpController::class, 'store']);


Route::get('/get-user/{id}', [App\Http\Controllers\OpenUserController::class, 'getUser']);







//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);


/*     ADMINSITRATOR          */
Route::resource('/admin-home', App\Http\Controllers\Administrator\AdminHomeController::class);

Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
Route::get('/get-user-offices', [App\Http\Controllers\Administrator\UserController::class, 'getOffices']);
Route::post('/user-reset-password/{id}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);



/*     ADMINSITRATOR          */


// FACULTY ROUTES
Route::resource('/faculty/home', App\Http\Controllers\Faculty\FacultyHomeController::class);


Route::resource('/faculty/my-pds', App\Http\Controllers\Faculty\FacultyMyPDSController::class);
Route::post('/faculty/my-pds-update/{id}', [App\Http\Controllers\Faculty\FacultyMyPDSController::class, 'update']);

Route::resource('/faculty/educational-backgrounds', App\Http\Controllers\Faculty\FacultyEducationalBackgroundController::class);
Route::resource('/faculty/children', App\Http\Controllers\Faculty\FacultyChildController::class);
Route::resource('/faculty/eligibilities', App\Http\Controllers\Faculty\FacultyCSEController::class);
Route::resource('/faculty/work-experiences', App\Http\Controllers\Faculty\FacultyWorkExperienceController::class);
Route::resource('/faculty/learning-developments', App\Http\Controllers\Faculty\FacultyLearningDevelopmentController::class);
Route::resource('/faculty/other-informations', App\Http\Controllers\Faculty\FacultyOtherInformationController::class);


Route::get('/session', function(){
    return Session::all();
});


Route::get('/before', function(){
    //return Session::all();


    $beforeDay = date('Y-m-d H:i', strtotime('+24 hour', strtotime(date('Y-m-d H:i'))));

    $data = \DB::table('appointments')
        ->where('appoint_date', date('Y-m-d', strtotime($beforeDay)))
        ->where('appoint_time', date('H:i', strtotime($beforeDay)))
        ->where('is_notify', 0)
        ->get();

    foreach($data as $i){

        $user = User::find($i->user_id);

        $msg = 'Hi '.$user->lname . ', ' . $user->fname . ', this is just a reminder that you have an appointment tomorrow. Your ref no. is: ' . $i->qr_code . '.';
        try{
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->post('http://'. env('IP_SMS_GATEWAY') .'/services/api/messaging?Message='.$msg.'&To='.$user->contact_no.'&Slot=1', []);
        }catch(Exception $e){} //just hide the error

        $appoint = Appointment::find($i->appointment_id);
        $appoint->is_notify = 1;
        $appoint->save();
    }

    //$beforeDay = date($today, strtotime('-1 day'));
    return $data;
});




Route::get('/collect', function(){
    return $collection = collect([1, 2, 3]);
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();


});
