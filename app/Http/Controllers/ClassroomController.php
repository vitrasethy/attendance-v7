<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Present;
use App\Models\Record;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin) {
            return Classroom::with('user')
                ->all();
        }

        return Classroom::with('user')
            ->where('user_id', auth()->id())
            ->orWhereIn('id', Student::select('classroom_id')
                ->where('user_id', auth()->id())
                ->get()
            )
            ->get();
    }

    public function store(Request $request)
    {
        $code = Str::random(12);
        while (Classroom::where('code', $code)->exists()) {
            $code = Str::random(12);
        }

        return Classroom::create([
            ...$request->validate([
                'name' => 'required|string|max:50',
            ]),
            'code' => $code,
            'user_id' => auth()->id(),
        ]);
    }

    public function show(Classroom $classroom)
    {
        $students = Student::with('user')->where('classroom_id', $classroom->id)->get();
        $records = Record::where('classroom_id', $classroom->id)->count();

        $students->each(function ($student) use ($records) {
            $attendanceCount = Present::where('student_id', $student->id)->count();
            $student->absence_count = $records - $attendanceCount;
        });

        return response()->json([
            'students' => $students,
            'classroom' => Classroom::where('id', $classroom->id)->first()
        ]);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $classroom->update($validated);

        return $classroom;
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return response()->json();
    }
}
