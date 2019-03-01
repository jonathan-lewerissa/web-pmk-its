<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Database\QueryException;

class PresensiController extends Controller
{
    public function index($id)
    {
        $event = Event::where('event_url',$id)->firstOrFail();
        $counter = $event->presensis->count();
        return view('presensi2',compact('id','event','counter'));
    }
    
    public function catat(Request $request)
    {
        try {
            $event = Event::where('event_url',$request->event_token)->firstOrFail();
            $inject = $event ->presensis()->create([
                'nrp' => $request->nrp
            ]);
            return response()->json([
                'message' => 'Success',
                'count' => $event->presensis->count()
            ]);
        } catch ( QueryException $e ) {
            return response()->json($e,500);
        }
    }
}
