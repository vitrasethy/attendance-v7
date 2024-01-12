<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AddStudentViaEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $classroom = Classroom::where('id', $validated['classroom_id'])->first();

        return Student::firstOrCreate(
            ['classroom_id' => $classroom->id, 'user_id' => $user->id],
            ['classroom_id' => $classroom->id, 'user_id' => $user->id]
        );
    }
}
