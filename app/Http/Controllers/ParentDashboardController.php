<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $parent = Auth::user();
        $children = User::where('parent_id', $parent->id)
            ->where('role', 'siswa')
            ->get();

        return view('parent.dashboard', compact('parent', 'children'));
    }

    public function children()
    {
        $parent = Auth::user();
        $children = User::where('parent_id', $parent->id)
            ->where('role', 'siswa')
            ->get();

        return view('parent.children', compact('children'));
    }

    public function childDetails($id)
    {
        $parent = Auth::user();
        $child = User::where('id', $id)
            ->where('parent_id', $parent->id)
            ->where('role', 'siswa')
            ->firstOrFail();

        return view('parent.child-details', compact('child'));
    }

    public function profile()
    {
        $parent = Auth::user();
        return view('parent.profile', compact('parent'));
    }

    public function updateProfile(Request $request)
    {
        $parent = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $parent->update($validated);

        return redirect()->route('parent.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function showChangePassword()
    {
        return view('parent.change-password');
    }

    public function updatePassword(Request $request)
    {
        $parent = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $parent->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $parent->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('parent.dashboard')->with('success', 'Password berhasil diubah!');
    }
}
