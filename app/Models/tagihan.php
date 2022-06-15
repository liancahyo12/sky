<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\booking;
use App\Models\pembayaran;

class tagihan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = [
        'booking_id', 
        'biaya', 
        'sisa_pembayaran', 
        'status_tagihan', 
        'keterangan', 
        'status'];

    protected $fillable = [
        'booking_id', 
        'biaya', 
        'sisa_pembayaran', 
        'status_tagihan', 
        'keterangan', 
        'status'];

    public function booking()
    {
        return $this->belongsTo(booking::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(pembayaran::class);
    }
}
