<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.patient-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|',
        ]);
        
        // Cari dokter berdasarkan email
        $patient = Patient::where('pemail', $request->email)->first();
    
    if ($patient && Hash::check($request->password, $patient->ppassword)) {
        Auth::guard('web')->login($patient); // Menggunakan guard 'web' untuk pasien
        return redirect()->intended('patient/index');
    } else {
        return redirect()->back()->withErrors(['pemail' => 'Invalid credentials.']);
    }
    // Jika tidak ada yang cocok, kembali dengan pesan error
    return redirect()->back()->withErrors(['pemail' => 'Invalid credentials.']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'pname' => 'required|string|max:255',
            'pemail' => 'required|email|unique:patient,pemail',
            'ppassword' => 'required|string|min:6|confirmed',
            'paddress' => 'required|string',
            'pdob' => 'required|date',
            'ptel' => 'required|string',
        ]);

        \Log::info('Signup request data:', $request->all());

        $patient = Patient::create([
            'pname' => $request->pname,
            'pemail' => $request->pemail,
            'ppassword' => Hash::make($request->ppassword),
            'paddress' => $request->paddress,
            'pdob' => $request->pdob,
            'ptel' => $request->ptel,
        ]);

    \Log::info('Created patient:', $patient->toArray());

        Auth::login($patient);

        return redirect('/');
    }
}