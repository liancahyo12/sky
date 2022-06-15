<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\tagihan;

class pembayaran extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = [
        'booking_id',  
        'pembayaran', 
        'biaya', 
        'sisa_tagihan', 
        'bukti_bayar', 
        'status_pembayaran', 
        'status_tagihan', 
        'waktu_bayar', 
        'keterangan', 
        'status'];

    protected $fillable = [
        'booking_id', 
        'pembayaran', 
        'biaya', 
        'sisa_tagihan', 
        'bukti_bayar', 
        'status_pembayaran', 
        'status_tagihan', 
        'waktu_bayar', 
        'keterangan', 
        'status'];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }
}
