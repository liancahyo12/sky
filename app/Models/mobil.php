<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;
use App\Models\booking;
use App\Models\transaksi;
use App\Models\biaya_mobil;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class mobil extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = ['user_id', 'mobil', 'tipe', 'merek', 'plat', 'sedia_status', 'status'];
    
    protected $fillable = [
        'user_id',
        'mobil',
        'tipe',
        'merek',
        'plat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->hasMany(booking::class);
    }

    public function biaya_mobil()
    {
        return $this->hasMany(biaya_mobil::class);
    }

    public function transaksi()
    {
        return $this->hasMany(transaksi::class);
    }
}
