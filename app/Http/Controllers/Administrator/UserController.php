<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Office;
use App\Models\OtherInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('administrator.user'); //blade.php
    }

    public function getUsers(Request $req){
        $sort = explode('.', $req->sort_by);

        $users = User::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $users;
    }

    public function show($id){
        return User::find($id);
    }

    public function storeOtherInfo(Request $req, $id){

        $validate = $req->validate([
            'skill_hobbies' => ['required']
        ]);

        OtherInformation::updateOrCreate([
            'user_id' => $id,
            'skill_hobbies' => $req->skill_hobbies,
        ],[
            'user_id' => $id,
            'skill_hobbies' => $req->skill_hobbies,
            'non_academic_distinction' => $req->non_academic_distinction,
            'member_association' => $req->member_association
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required', 'string'],
            'res_province' => ['required', 'string'],
            'res_city' => ['required', 'string'],
            'res_barangay' => ['required', 'string'],
        ]);

        User::create([
            'qr_ref' => $qr_code,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'sex' => $req->sex,
            'email' => $req->email,
            'contact_no' => $req->contact_no,
            'role' => $req->role,
            'cid_sub_role' => $req->cid_sub_role,
            'res_province' => $req->res_province,
            'res_city' => $req->res_city,
            'res_barangay' => $req->res_barangay,
            'res_street' => strtoupper($req->res_street)
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        //return $req;

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users,username,'.$id.',user_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users,email,'.$id.',user_id'],
            'role' => ['required', 'string'],
            'res_province' => ['required', 'string'],
            'res_city' => ['required', 'string'],
            'res_barangay' => ['required', 'string'],
        ]);

        $data = User::find($id);
        $data->username = $req->username;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->sex = $req->sex;
        $data->email = $req->email;
        $data->role = $req->role;
        $data->cid_sub_role = $req->cid_sub_role;
        $data->res_province = $req->res_province;
        $data->res_city = $req->res_city;
        $data->res_barangay = $req->res_barangay;
        $data->res_street = strtoupper($req->res_street);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function getBrowseDentist(Request $req){

        $data = User::where('lname', 'like', $req->lname . '%')
            ->where('fname', 'like', $req->fname . '%')
            ->where('role', 'DENTIST')
            ->paginate($req->perpage);
        return $data;
    }

    public function resetPassword(Request $req, $id){

        $req->validate([
            'password' => ['required', 'confirmed']
        ]);

        $user = User::find($id);
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'status' => 'changed'
        ],200);


    }

    public function destroy($id){
        User::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }
}
