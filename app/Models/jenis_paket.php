<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\biaya_mobil;
use App\Models\booking;

class jenis_paket extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = [
        'jenis_paket', 
        'status'];

    protected $fillable = [
        'jenis_paket', 
        'status'];
    
    public function biaya_mobil()
    {
        return $this->hasMany(biaya_mobil::class);
    }

    public function booking()
    {
        return $this->hasMany(booking::class);
    }
}
