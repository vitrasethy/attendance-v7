<?php

namespace App\Http\Controllers;

use App\Models\Present;
use App\Models\Record;
use App\Models\Student;
use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'record_id' => 'required|exists:records,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'record_code' => 'required',
        ]);

        if (!Record::where('code', $validated['record_code'])->exists()) {
            return response()->json([
                'message' => $validated['record_code']
            ], 422);
        }

        $student = Student::where('user_id', auth()->id())
            ->where('classroom_id', $validated['classroom_id'])
            ->first();

        $data = [
            'record_id' => $validated['record_id'],
            'student_id' => $student->id,
        ];

        return Present::create($data);
    }

    public function show(Present $present)
    {
        return $present;
    }

    public function update(Request $request, Present $present)
    {
        $data = $request->validate([

        ]);

        $present->update($data);

        return $present;
    }

    public function destroy(Present $present)
    {
        $present->delete();

        return response()->json();
    }
}
