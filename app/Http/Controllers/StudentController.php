<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index', [
            'title' => 'Mahasiswa',
            'users' => Mahasiswa::paginate(10)
        ]);
    }

    public function create()
    {
        return view('student.create', [
            'title' => 'New Student',
            'mahasiswa' => Mahasiswa::paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Mahasiswa::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'telp' => $request->no_telp,
            'dob' => $request->tanggal_lahir,
            'prodi' => $request->prodi,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
            'is_active' => true,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('student.index')->with('message', 'Student added successfully!');
    }
}
