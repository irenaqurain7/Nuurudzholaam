<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,orangtua,siswa',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->to($this->redirectByRole($user))->with('success', 'Registrasi berhasil!');
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

        $user = User::where('username', $credentials['login'])
            ->orWhere('name', $credentials['login'])
            ->orWhere('email', $credentials['login'])
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
            'login' => 'Username/Email/NISN/NIP atau password tidak sesuai.',
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
        if ($user->role === 'siswa') {
            return route('student.dashboard');
        } elseif ($user->role === 'guru') {
            return route('teacher.dashboard');
        } elseif ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'orangtua') {
            return route('parent.dashboard');
        }
        return route('login');
    }
}
