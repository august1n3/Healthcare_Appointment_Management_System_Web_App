<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\authenticateUser;
use App\Http\Middleware\checkAuthState;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signin', function () {
    return view('signin');
})->middleware(checkAuthState::class);

Route::post('/signinuser', function (Request $request) {
    $id = number_format($request->input('userID'));
    $password = $request->input('password');
    $users = User::query()->where('id', '=', $id)->get();
    $checkpassword = $users[0]->password;
    
    if(Hash::check($password,$checkpassword)){
        $request->session()->regenerate();
        $request->session()->put('userID', $id);
        $request->session()->put('role', $users[0]->role);

        return redirect('/dashboard');
    }
    else{
        return "failed";
    }
})->middleware(checkAuthState::class);



Route::prefix('dashboard')->group(function () {
    Route::middleware([authenticateUser::class])->group(function () {

    Route::get('/', function (Request $request) {
        return view('dashboard-home')->with('user_role', $request->session()->get('role'));
    });
    
    Route::get('/patients', function (Request $request) {
        $patients = Patient::query()->get();
    
        return view('dashboard-patients')
        ->with('patients', $patients)
        ->with('user_role', $request->session()->get('role'));
        return view('dashboard-patients');
    });
    Route::post('/patient', function (Request $request) {
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $middlename = $request->input('middle_name');
        $phonenumber = $request->input('phone_number');
        $email = $request->input('email');
        $gender = $request->input('gender');
        $birthdate = $request->input('birth_date');

        $doctorID = Patient::insertGetId([
            'first_name' => $firstname,
            'last_name' => $lastname,
            'middle_name' => "null",
            'phone_number' => $phonenumber,
            'email' => $email,
            'gender' => $gender,
            'birth_date' => $birthdate
        ]);

        return back();
    });
    Route::get('/appointments', function (Request $request) {
        $appointments = Appointment::query()->get();

        return view('dashboard-appointments', ['appointments' => $appointments])->with('user_role', $request->session()->get('role'));
    });
    
    Route::get('/doctors', function (Request $request) {
        $doctors = Doctor::query()->get();
    
        return view('dashboard-doctors',['doctors' => $doctors])->with('user_role', $request->session()->get('role'));
    });
    Route::post('/doctor', function (Request $request) {
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $middlename = $request->input('middle_name');
        $specialization = $request->input('specialization');
        $email = $request->input('email');
        $gender = $request->input('gender');
        $dateHire = $request->input('hire_date');

        $doctorID = Doctor::insertGetId([
            'first_name' => $firstname,
            'last_name' => $lastname,
            'middle_name' => $middlename,
            'specialization' => $specialization,
            'hired_date' => $dateHire
        ]);

        User::insert([
            'email' => $email,
            'role' => 'doctor',
            'doctor_id' => $doctorID,
            'password' => '1234567890'
        ]);

        return back();
    });
    });
});