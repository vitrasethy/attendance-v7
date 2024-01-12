<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RecordController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $code = Str::random(30);
        while (Record::where('code', $code)->exists()) {
            $code = Str::random(12);
        }

        return Record::create([
            'code' => $code,
            'classroom_id' => $data['classroom_id'],
        ]);
    }

    public function show(Record $record)
    {
        return $record;
    }

    public function update(Request $request, Record $record)
    {
        $data = $request->validate([

        ]);

        $record->update($data);

        return $record;
    }

    public function destroy(Record $record)
    {
        $record->delete();

        return response()->json();
    }
}
