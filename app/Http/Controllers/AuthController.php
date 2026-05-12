<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->to($this->redirectByRole(Auth::user()));
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['login'])
            ->orWhere('nisn', $credentials['login'])
            ->orWhere('nip', $credentials['login'])
            ->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Akun tidak ditemukan.',
            ]);
        }

        if (Auth::attempt(['email' => $user->email, 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun Anda telah dinonaktifkan. Hubungi admin sekolah.',
                ]);
            }

            return redirect()->intended($this->redirectByRole($user));
        }

        return back()->withErrors([
            'login' => 'Username/NISN/NIP atau password tidak sesuai.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Redirect user based on role
     */
    private function redirectByRole($user)
    {
        if ($user->isStudent()) {
            return route('student.dashboard');
        } elseif ($user->isTeacher()) {
            return route('teacher.dashboard');
        } elseif ($user->isAdmin()) {
            return route('admin.dashboard');
        }
        return route('login');
    }
}
