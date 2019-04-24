<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresensiUmum extends Model
{
    protected $fillable = ['nama', 'asal', 'telp'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
