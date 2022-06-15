<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\pelanggan;
use App\Models\driver;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class jenis_identitas extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logAttributes = ['jenis_identitas', 'status'];

    protected $fillable = [
        'jenis_identitas',
    ];

    public function pelanggan()
    {
        return $this->hasMany(pelanggan::class);
    }

    public function driver()
    {
        return $this->hasMany(driver::class);
    }
}
