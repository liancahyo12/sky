<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;
use App\Models\booking;
use App\Models\driver;
use App\Models\mobil;
use App\Models\pelanggan;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class transaksi extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = [
        'booking_id',
        'user_id',
        'driver_id',
        'mobil_id',
        'pelanggan_id',
        'noinvoice',
        'biaya',
        'bukti_bayar',
        'status_biaya',
        'biaya_investor',
        'biaya_danlap',
        'biaya_adm',
        'biaya_bbmtol',
        'biaya_driver',
        'status',
    ];

    protected $fillable = [
        'booking_id',
        'user_id',
        'driver_id',
        'mobil_id',
        'pelanggan_id',
        'noinvoice',
        'biaya',
        'bukti_bayar',
        'status_biaya',
        'biaya_investor',
        'biaya_danlap',
        'biaya_adm',
        'biaya_bbmtol',
        'biaya_driver',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function mobil()
    {
        return $this->belongsTo(mobil::class);
    }

    public function driver()
    {
        return $this->belongsTo(driver::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }

    public function booking()
    {
        return $this->belongsTo(booking::class);
    }
}
