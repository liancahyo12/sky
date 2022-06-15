<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\mobil;

class biaya_mobil extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = ['mobil_id', 
        'biaya', 
        'biaya_investor', 
        'biaya_danlap', 
        'biaya_adm', 
        'biaya_bbmtol', 
        'biaya_driver', 
        'luar_dalam_kota', 
        'jenis_paket_id', 
        'status'];

    protected $fillable = ['mobil_id', 
        'biaya', 
        'biaya_investor', 
        'biaya_danlap', 
        'biaya_adm', 
        'biaya_bbmtol', 
        'biaya_driver', 
        'luar_dalam_kota', 
        'jenis_paket_id', 
        'status'];

    public function mobil()
    {
        return $this->belongsTo(mobil::class);
    }
}
