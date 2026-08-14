<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
        ]);

        $lastStudent = Student::latest('id')->first();
        $nextNumber = $lastStudent ? $lastStudent->id + 1 : 1;
        $validate['nis'] = 'NIS' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $student = Student::create($validate);

        return response()->json([
            'message' => 'Data Berhasil ditambahkan',
            'data' => $student,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);

        return response()->json([
            'data' => $student,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
        ]);

        $student = Student::find($id);

        if(!$student){
            return response()->json([
                'message' => 'Data tidak Ditemukan',
            ], 404);
        }

        $student->update($validate);

        return response()->json([
            'message' => 'Data berhasil diupdate',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Data tidak Ditemukan',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Data berhasil Dihapus',
        ], 200);
    }
}
