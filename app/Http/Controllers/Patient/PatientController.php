<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Session;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Method untuk mengambil data umum yang diperlukan
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

    // Method untuk menampilkan halaman index patient
    public function index()
    {
        $user = Auth::user();
    $data = $this->getGeneralData();
    return view('patient/index', $data);
    }
    
    // Method untuk menampilkan halaman daftar dokter patient
    public function doctors()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        $doctors = Doctor::orderBy('docid', 'desc')->get();
        $list = Doctor::select('docname', 'docemail')->get();
        $specialties = Specialty::all(); // Ambil semua spesialisasi
        $list11 = Doctor::all(); // Atau query yang sesuai untuk mendapatkan jumlah baris
    
        return view('patient.doctors', compact('user', 'doctors', 'list', 'list11', 'specialties'));
    }

    // Method untuk pencarian dokter
    public function searchDoctor(Request $request)
    {
        $searchTerm = $request->input('search');

        $doctors = Doctor::where('docname', 'like', '%' . $searchTerm . '%')->get();

        return view('patient.doctor', compact('doctors'));
    }

    // Method untuk menampilkan halaman sesi yang dijadwalkan patient
 // Method untuk menampilkan halaman sesi yang dijadwalkan patient
public function schedule(Request $request)
{
    $data = $this->getGeneralData();
    
    $searchTerm = $request->input('search');
    
    $schedules = Schedule::where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('scheduledate', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('doctor', function ($query) use ($searchTerm) {
                            $query->where('docname', 'like', '%' . $searchTerm . '%');
                        })
                        ->orderBy('scheduledate')
                        ->orderBy('scheduletime')
                        ->get();

    $data['schedules'] = $schedules;

    // Ambil daftar dokter untuk ditampilkan di form pencarian
    $doctors = Doctor::distinct()->select('docname')->get();
    
    // Mengambil semua jadwal (mungkin hanya untuk keperluan tambahan)
    // $schedules = Schedule::all(); // Tidak perlu diambil lagi karena sudah di atas
    $list11 = Schedule::all();
    // Ambil user yang sedang login
    $user = Auth::user();
    // Kembalikan view dengan data yang dibutuhkan
    return view('patient.schedule', compact('user', 'doctors', 'schedules','list11'));
}

public function searchSchedule(Request $request)
{
    $data = $this->getGeneralData();
    
    // Lakukan pencarian sesuai dengan input yang diberikan
    $searchTerm = $request->input('search');
    
    // Lakukan query untuk mencari jadwal berdasarkan judul, tanggal, atau nama dokter
    $schedules = Schedule::where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('scheduledate', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('doctor', function ($query) use ($searchTerm) {
                            $query->where('docname', 'like', '%' . $searchTerm . '%');
                        })
                        ->orderBy('scheduledate')
                        ->orderBy('scheduletime')
                        ->get();

    // Menyimpan hasil pencarian jadwal ke dalam data
    $data['schedules'] = $schedules;
    
    // Ambil daftar dokter untuk ditampilkan di form pencarian
    $doctors = Doctor::distinct()->select('docname')->get();
    
    // Ambil user yang sedang login
    $user = Auth::user();
    
    // Variabel untuk judul halaman (opsional)
    $searchschedule = "Your Search Results"; // Misalnya
    
    // Kembalikan view dengan data yang dibutuhkan
    return view('patient.schedule', compact('user', 'doctors', 'schedules', 'searchschedule'));
}

    public function appointment(Request $request, $id = null)
    {
        $user = auth()->user();
        $appointments = Appointment::where('pid', $user->id)->get();
        $schedules = Schedule::all();

        if ($request->has('scheduledate')) {
            $appointments = $appointments->where('appodate', $request->input('scheduledate'));
        }

        if ($request->has('action')) {
            $action = $request->input('action');
            $appointmentId = $request->input('id');
            $appointment = Appointment::find($appointmentId);

            if ($action === 'view' && $appointment) {
                $doctor = $appointment->schedule->doctor; // Assuming Schedule has relation with Doctor
                return view('patient.view_appointment', compact('appointment', 'doctor'));
            }

            if ($action === 'drop' && $appointment) {
                $appointment->delete();
                return redirect()->route('patient.appointment')->with('success', 'Appointment canceled successfully.');
            }
        }

        return view('patient.appointment', compact('appointments', 'schedules', 'user'));
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('patient.appointment')->with('success', 'Appointment canceled successfully.');
    }
    
    public function setting(Request $request)
    {
        $user = auth()->user();
        return view('patient.settings', compact('user'));
    }

    // Method untuk mengedit data user
    public function editUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'Tele' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->tele = $request->Tele;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('patient.settings')->with('success', 'User details updated successfully!');
    }

    // Method untuk menghapus akun
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json('Failed to delete account. Incorrect password.', 400);
        }

        $user->delete();

        return response()->json('success');
    }
}
