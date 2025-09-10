<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SatpamController extends Controller
{
    public function index()
    {
        // Ambil data satpam dengan pagination
        $satpam = User::where('role', 'satpam')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.satpam.index', compact('satpam'));
    }

    public function create()
    {
        return view('admin.satpam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'satpam'
        ]);

        return redirect()
            ->route('admin.satpam.index')
            ->with('success', 'Akun Satpam berhasil dibuat.');
    }
    // AdminController.php
    public function edit($id)
    {
        $satpam = User::where('role', 'satpam')->findOrFail($id);
        return view('admin.satpam.edit', compact('satpam'));
    }

    public function update(Request $request, $id)
    {
        $satpam = User::where('role', 'satpam')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $satpam->id,
            'password' => 'nullable|string|min:8', // password opsional saat edit
        ]);

        $satpam->name = $validated['name'];
        $satpam->email = $validated['email'];

        if (!empty($validated['password'])) {
            $satpam->password = Hash::make($validated['password']);
        }

        $satpam->save();

        return redirect()->route('admin.satpam.index')->with('success', 'Data satpam berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Pastikan yang dihapus benar-benar satpam
        if ($user->role !== 'satpam') {
            return redirect()->route('admin.satpam.index')
                ->with('error', 'Hanya akun satpam yang bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.satpam.index')
            ->with('success', 'Akun Satpam berhasil dihapus.');
    }
}
