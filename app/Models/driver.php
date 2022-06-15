<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\booking;
use App\Models\transaksi;
use App\Models\jenis_identitas;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class driver extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = ['nama', 'jenis_identitas', 'no_identitas', 'alamat', 'sedia_status', 'status'];

    protected $fillable = [
        'nama',
        'jenis_identitas',
        'no_identitas',
        'alamat',
    ];

    public function booking()
    {
        return $this->hasMany(booking::class);
    }

    public function transaksi()
    {
        return $this->hasMany(transaksi::class);
    }

    public function jenis_identitas()
    {
        return $this->belongsTo(jenis_identitas::class);
    }
}
