<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoTag extends Model
{
    use HasFactory;

    protected $table = 'geotags';
    protected $primaryKey = 'geotag_id';
    
    protected $fillable = [
        'resident_id',
        'latitude',
        'longitude',
        'location_address',
        'timestamp',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'timestamp' => 'datetime',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'resident_id');
    }
}
