<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewNeraca extends Model
{
    protected $table = 'view_neraca';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function () { return false; });
        static::creating(function () { return false; });
        static::updating(function () { return false; });
        static::deleting(function () { return false; });
    }

    public function getSaldoFormattedAttribute()
    {
        return number_format($this->saldo_akhir, 0, ',', '.');
    }
}
