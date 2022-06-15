<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\jenis_identitas;
use App\Models\booking;
use App\Models\transaksi;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class pelanggan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = ['nama', 'jenis_identitas', 'no_identitas', 'alamat', 'alias', 'group', 'kenalan', 'status'];

    protected $fillable = [
        'nama',
        'jenis_identitas_id',
        'no_identitas',
        'foto_identitas',
        'alamat',
        'alias',
        'group',
        'kenalan',
    ];

    public function jenis_identitas()
    {
        return $this->belongsTo(jenis_identitas::class);
    }

    public function booking()
    {
        return $this->hasMany(booking::class);
    }

    public function transaksi()
    {
        return $this->hasMany(transaksi::class);
    }
}
