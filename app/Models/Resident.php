<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resident extends Authenticatable
{
    use HasFactory;

    protected $table = 'residents';
    protected $primaryKey = 'resident_id';
    
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'age',
        'civil_status',
        'purok',
        'barangay',
        'city',
        'indigent_status',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'resident_id', 'resident_id');
    }

    public function financialAssistance()
    {
        return $this->hasMany(FinancialAssistance::class, 'resident_id', 'resident_id');
    }

    public function geoTags()
    {
        return $this->hasMany(GeoTag::class, 'resident_id', 'resident_id');
    }
}
