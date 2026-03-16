<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.barang.index')
                : redirect()->route('user.katalog');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.barang.index');
            }
            return redirect()->route('user.katalog');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap'     => 'required|string|min:3|max:40',
            'email'            => [
                'required', 'string', 'email', 'max:255', 'unique:users',
                'regex:/^[a-zA-Z0-9._%+\-]+@gmail\.com$/'
            ],
            'password'         => 'required|string|min:6|max:12|confirmed',
            'nomor_handphone'  => ['required', 'string', 'regex:/^08[0-9]{7,12}$/'],
        ], [
            'email.regex'            => 'Email harus menggunakan @gmail.com',
            'nomor_handphone.regex'  => 'Nomor handphone harus diawali dengan 08',
            'password.min'           => 'Password minimal 6 karakter',
            'password.max'           => 'Password maksimal 12 karakter',
        ]);

        $user = User::create([
            'nama_lengkap'    => $request->nama_lengkap,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'nomor_handphone' => $request->nomor_handphone,
            'role'            => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('user.katalog')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
