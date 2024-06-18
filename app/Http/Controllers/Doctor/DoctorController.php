<?php
// app/Http/Controllers/Patient/DoctorController.php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;


class DoctorController extends Controller
{
    private function getGeneralData()
    {
        return [
            'user' => Auth::user(),
            //'doctorCount' => Doctor::count(),
            'patientCount' => Patient::count(),
            'appointmentCount' => Appointment::count(),
            'sessionCount' => Session::count(),
            'appointments' => Appointment::all(),
        ];
    }
    public function index()
    {
        $user = Auth::user();
    $data = $this->getGeneralData();
    return view('doctor.index', $data);
    }

    public function view($id)
    {
        // Ambil data dokter berdasarkan ID
        $doctor = Doctor::find($id);
        return view('patient.doctor', compact('doctor'));
    }

    public function edit($id)
    {
        // Ambil data dokter berdasarkan ID untuk diedit
        $doctor = Doctor::find($id);
        return view('patient.doctor', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        // Validasi dan simpan data yang diperbarui
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'tele' => 'required',
            'spec' => 'required',
            'password' => 'required|min:8',
            'cpassword' => 'required|same:password',
        ]);

        $doctor = Doctor::find($id);
        $doctor->docname = $request->name;
        $doctor->docemail = $request->email;
        $doctor->doctel = $request->tele;
        $doctor->specialties = $request->spec;
        $doctor->docpassword = bcrypt($request->password);
        $doctor->save();

        return redirect()->route('patient.doctors')->with('success', 'Doctor updated successfully!');
    }

    public function delete($id)
    {
        // Hapus dokter berdasarkan ID
        $doctor = Doctor::find($id);
        $doctor->delete();

        return redirect()->route('patient.doctors')->with('success', 'Doctor deleted successfully!');
    }
}
