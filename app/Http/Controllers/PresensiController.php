<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Database\QueryException;
use App\Exports\EventUmumExport;
use App\Exports\EventExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function index($id)
    {
        $event = Event::where('event_url',$id)->firstOrFail();
        $eventp = Event::where('event_url',$id)->firstOrFail();
        if($eventp->type == 'PU') {
            $counter = $eventp->presensi_umums->count();
            return view('presensi2',compact('id','event','counter'));
        }
        $counter = $eventp->presensis->count();
        return view('presensi2',compact('id','event','counter'));
    }
    
    public function catat(Request $request)
    {
        try {
            $event = Event::where('event_url',$request->event_token)->firstOrFail();
            if($event->type == 'PU'){
                $inject = $event->presensi_umums()->create([
                    'nama' => $request->nama,
                    'asal' => $request->asal,
                    'telp' => $request->telp
                ]);
            } else {
                $inject = $event->presensis()->create([
                    'nrp' => $request->nrp
                ]);
            }
            
            return response()->json([
                'message' => 'Success',
                'count' => $event->presensis->count()
            ]);
        } catch ( QueryException $e ) {
            return response()->json($e,500);
        }
    }

    public function retrieveAll($id)
    {
        $event = Event::where('event_url',$id)->with('presensis')->firstOrFail();
        $presensis = $event->presensis;
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($presensis,['created_at','nrp'])->download('rekap_presensi_'.$event->title.'_'.$event->event_start.'.csv');
    }

    public function retrieveAllExcel($id)
    {
        $event = Event::where('event_url',$id)->firstOrFail();
        if($event->type == 'PU') {
            return Excel::download(new EventUmumExport($id), 'rekap_presensi_'.$id.'.xlsx');
        } else {
            return Excel::download(new EventExport($id), 'rekap_presensi_'.$id.'.xlsx');
        }
    }
}
