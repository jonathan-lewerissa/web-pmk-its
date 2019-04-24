<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Event extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'events';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title','type','description','event_start','event_end','event_url'];
    // protected $hidden = [];
    protected $dates = ['event_start','event_end'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getPublicURL()
    {
        return '<a href="'.url("/presensi/e/{$this->event_url}").'" target="_blank">'.url("/presensi/{$this->event_url}").'</a>';
    }

    public function openGoogle()
    {
        return '<a class="btn btn-xs btn-default" target="_blank" href="'.url("/presensi/d/{$this->event_url}").'"><i class="fa fa-search"></i>Download Excel</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function presensis()
    {
        return $this->hasMany('App\Presensi');
    }

    public function presensi_umums()
    {
        return $this->hasMany('App\PresensiUmum');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
