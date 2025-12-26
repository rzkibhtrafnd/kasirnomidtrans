<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    public function index()
    {
        $kasirs = User::where('role', 'kasir')->latest()->paginate(7);
        return view('admin.kasir.index', compact('kasirs'));
    }

    public function create()
    {
        return view('admin.kasir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'kasir'
        ]);

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kasir = User::findOrFail($id);
        return view('admin.kasir.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $kasir = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,$kasir->id",
        ]);

        $kasir->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil dihapus.');
    }
}
