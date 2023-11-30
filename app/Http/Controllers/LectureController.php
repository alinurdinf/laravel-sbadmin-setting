<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        return view('lecture.index', [
            'title' => 'Dosen',
            'users' => Dosen::paginate(10)
        ]);
    }

    public function create()
    {
        return view('lecture.create', [
            'title' => 'New Lecture',
            'dosen' => Dosen::paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Dosen::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'telp' => $request->no_telp,
            'dob' => $request->tanggal_lahir,
            'prodi' => $request->prodi,
            'is_active' => true,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('lecture.index')->with('message', 'Lecture added successfully!');
    }
}
