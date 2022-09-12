<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;

class CalendarController extends Controller
{
    public function calendar(Request $request) {
        $calendar = Calendar::create([
            'title' => $request->input('title'),
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return response()->json($calendar);
    }

    public function fetchData() {
        $fetch = Calendar::all();
        return response()->json($fetch);
    }
}
