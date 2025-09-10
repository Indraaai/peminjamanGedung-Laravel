<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::latest()->get();
        return view('admin.gedung.index', compact('gedungs'));
    }

    public function create()
    {
        return view('admin.gedung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string',
        ]);

        Gedung::create($request->only(['nama', 'deskripsi', 'lokasi']));

        return redirect()->route('admin.gedung.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit(Gedung $gedung)
    {
        return view('admin.gedung.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string',
        ]);

        $gedung->update($request->only(['nama', 'deskripsi', 'lokasi']));

        return redirect()->route('admin.gedung.index')->with('success', 'Gedung berhasil diupdate.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return redirect()->route('admin.gedung.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
