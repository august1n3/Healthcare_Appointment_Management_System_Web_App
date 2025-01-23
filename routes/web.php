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

Route::get('/dashboard', function () {
    return view('dashboard-home');
})->middleware(authenticateUser::class);

Route::get('/dashboard/patients', function () {
    return view('dashboard-patients');
});

Route::get('/dashboard/appointments', function () {
    return view('dashboard-appointments');
});

Route::get('/dashboard/doctors', function () {
    $doctors = Doctor::query()->get();

    return view('dashboard-doctors',['doctors' => $doctors]);
});
