<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;
use App\Models\pelanggan;
use App\Models\driver;
use App\Models\mobil;
use App\Models\jenis_paket;
use App\Models\tagihan;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class booking extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = [
        'pelanggan_id',
        'jenis_paket_id',
        'biaya_mobil_id',
        'mobil_id',
        'driver_id',
        'awal_sewa',
        'akhir_sewa',
        'wilayah_id',
        'noinvoice',
        'hari',
        'biaya',
        'biaya_investor', 
        'biaya_danlap', 
        'biaya_adm', 
        'biaya_bbmtol', 
        'biaya_driver', 
        'bukti_bayar',
        'status_biaya',
        'booking_status',
        'file_tagihan',
        'sisa_tagihan',
        'status_tagihan',
    ];
    
    protected $fillable = [
        'pelanggan_id',
        'jenis_paket_id',
        'biaya_mobil_id',
        'mobil_id',
        'driver_id',
        'awal_sewa',
        'akhir_sewa',
        'wilayah_id',
        'noinvoice',
        'hari',
        'biaya',
        'biaya_investor', 
        'biaya_danlap', 
        'biaya_adm', 
        'biaya_bbmtol', 
        'biaya_driver', 
        'bukti_bayar',
        'status_biaya',
        'booking_status',
        'file_tagihan',
        'sisa_tagihan',
        'status_tagihan',
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

    public function jenis_paket()
    {
        return $this->belongsTo(jenis_paket::class);
    }

    public function transaksi()
    {
        return $this->hasOne(transaksi::class);
    }

    public function tagihan()
    {
        return $this->hasOne(tagihan::class);
    }
}
