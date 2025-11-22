<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewRekapSimpanan extends Model
{
    protected $table = 'view_rekap_simpanan';
    protected $primaryKey = null; 
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(fn() => false);
        static::creating(fn() => false);
        static::updating(fn() => false);
        static::deleting(fn() => false);
    }
}
