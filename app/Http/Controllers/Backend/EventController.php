<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function add(AddEventRequest $request)
    {
        try {
            $event = new Event();
            $event->date = date('Y-m-d', strtotime($request->date));
            $event->note = $request->note;
            return response()->json([
                'msg' => $event->save() ? 'success' : 'error'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'msg' => 'error',
                'data' => $exception
            ]);
        }
    }
}
