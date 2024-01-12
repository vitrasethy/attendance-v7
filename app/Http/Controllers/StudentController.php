<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:classrooms'
        ]);

        $classroom = Classroom::where('code', $request->code)->first();

        return Student::firstOrCreate(
            ['classroom_id' => $classroom->id, 'user_id' => auth()->id()],
            ['classroom_id' => $classroom->id, 'user_id' => auth()->id()]
        );
    }

    public function show(Student $student)
    {
    }

    public function update(Request $request, Student $student)
    {
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->noContent();
    }
}
