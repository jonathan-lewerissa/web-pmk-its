<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = ['nrp','photo_url'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
