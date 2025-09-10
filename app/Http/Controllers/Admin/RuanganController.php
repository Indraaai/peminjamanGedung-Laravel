<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Gedung;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::with('gedung')->get();
        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        $gedungs = Gedung::all();
        return view('admin.ruangan.create', compact('gedungs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'gedung_id' => 'required|exists:gedungs,id',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-ruangan', 'public');
        }

        Ruangan::create($validated);
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        $gedungs = Gedung::all();
        return view('admin.ruangan.edit', compact('ruangan', 'gedungs'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'gedung_id' => 'required|exists:gedungs,id',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-ruangan', 'public');
        }

        $ruangan->update($validated);
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan diubah.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return back()->with('success', 'Ruangan dihapus.');
    }
}
