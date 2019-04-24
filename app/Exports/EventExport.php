<?php

namespace App\Exports;

use App\Models\Event;
use App\Presensi;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventExport implements FromQuery, WithMapping
{
    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function query()
    {
        $event = Event::where('event_url',$this->id)->firstOrFail();
        return Presensi::query()->where('event_id',$event->id)->orderBy('created_at','asc');
    }

    public function map($presensi): array
    {
        return [
            $presensi->created_at,
            $presensi->nrp,
            $presensi->nama
        ];
    }
}
