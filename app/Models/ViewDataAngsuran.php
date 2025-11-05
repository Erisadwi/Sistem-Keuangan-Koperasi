<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAngsuran extends Model
{
    protected $table = 'view_data_angsuran'; 

    public $incrementing = false; 
    public $timestamps = false;   

    protected $primaryKey = null; 
    protected $guarded = [];     
}
