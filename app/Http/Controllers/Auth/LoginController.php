<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function username()
    {
        return 'nip'; // login pakai NIP
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nip', 'password');

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'nip' => ['NIP atau password salah.'],
            ]);
        }

        $user = Auth::user();

        if (! $user->is_confirmed) {
            Auth::logout();
            return back()->withErrors(['nip' => 'Akun Anda belum dikonfirmasi oleh admin.']);
        }

        $request->session()->regenerate();

        // melakukan autentikasi admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.page.dashboard');
        }elseif ($user->role === 'kepsek') {
            return redirect()->route('kepsek.dashboard');
        }elseif ($user->role === 'guru_mapel') {
            return redirect()->route('gurumapel.home_gurumapel');
        }

        return redirect()->intended('/dashboard'); // masuk ke tampilan guru mapel

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    
}