<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLabaRugi extends Model
{
    protected $table = 'view_laba_rugi';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    // Jika ingin pastikan model ini read-only (tidak bisa insert/update/delete)
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            return false;
        });
        static::creating(function ($model) {
            return false;
        });
        static::updating(function ($model) {
            return false;
        });
        static::deleting(function ($model) {
            return false;
        });
    }
}
