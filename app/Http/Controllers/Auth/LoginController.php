<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


use App\Models\User;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (!$user) {
            // User tidak ditemukan
            $activityLog = new ActivityLog;
            $activityLog->activity_type = 'login_failed';
            $activityLog->description = 'Percobaan login gagal untuk username: ' . $request->input('username');
            $activityLog->ip_address = $request->ip();
            $activityLog->data = ['additional_info' => 'Data tambahan jika diperlukan'];
            $activityLog->save();

            Alert::error('Account yang Anda masukkan salah!', 'Error Login');
            return back();
        }

        if ($user->role === 'Siswa') {
            // Peran "Pelanggan" tidak diizinkan untuk login
            $activityLog = new ActivityLog;
            $activityLog->activity_type = 'login_failed';
            $activityLog->description = 'Percobaan login gagal untuk username: ' . $request->input('username') . ' (Peran "Pelanggan" tidak diizinkan untuk login)';
            $activityLog->ip_address = $request->ip();
            $activityLog->data = ['additional_info' => 'Data tambahan jika diperlukan'];
            $activityLog->save();

            Alert::warning('Anda tidak diizinkan untuk login!', 'Oopss');
            return back();
        }

        if (auth()->attempt($request->only('username', 'password'), $request->has('remember_token'))) {
            // Login berhasil
            $activityLog = new ActivityLog;
            $activityLog->user_id = auth()->user()->id;
            $activityLog->activity_type = 'login_success';
            $activityLog->description = 'Pengguna ' . auth()->user()->name . ' berhasil login';
            $activityLog->ip_address = $request->ip();
            $activityLog->data = ['additional_info' => 'Data tambahan jika diperlukan'];
            $activityLog->save();

            Alert::success('Anda berhasil login', 'Login Success');
            return redirect('app/dashboard');
        } else {
            // Login gagal
            $activityLog = new ActivityLog;
            $activityLog->activity_type = 'login_failed';
            $activityLog->description = 'Percobaan login gagal untuk username: ' . $request->input('username');
            $activityLog->ip_address = $request->ip();
            $activityLog->data = ['additional_info' => 'Data tambahan jika diperlukan'];
            $activityLog->save();

            Alert::error('Account yang Anda masukkan salah!', 'Error Login');
            return back();
        }
    }
}
