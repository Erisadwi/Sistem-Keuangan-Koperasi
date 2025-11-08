<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ViewDataAngsuran extends Model
{
    protected $table = 'view_data_angsuran';

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;
    protected $guarded = [];

    public function getTanggalPinjamanAttribute($value)
    {
        if (!$value) return null;
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getTanggalJatuhTempoAttribute($value)
    {
        if (!$value) return null;
        return Carbon::parse($value)->format('d-m-Y');
    }
}
