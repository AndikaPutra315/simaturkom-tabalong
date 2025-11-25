<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import class Auth

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = '/suadmin/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('suadmin.login');
    }

    /**
     * Tangani permintaan login menggunakan database.
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required'], // Laravel menggunakan 'email' sebagai username default
            'password' => ['required'],
        ]);

        // 2. Coba lakukan login menggunakan data dari database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerasi session untuk keamanan

            // Kita tetap set session ini agar middleware 'is_admin' tetap berfungsi
            $request->session()->put('loggedInAsAdmin', true);

            return redirect()->intended($this->redirectTo);
        }

        // 3. Jika login gagal, kembali ke form dengan pesan error
        return back()->withErrors([
            'email' => 'ID atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('loggedInAsAdmin'); // Hapus session admin saat logout
        return redirect('/');
    }
}
