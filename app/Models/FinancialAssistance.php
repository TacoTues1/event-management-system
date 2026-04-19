<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAssistance extends Model
{
    use HasFactory;

    protected $table = 'financial_assistance';
    protected $primaryKey = 'assistance_id';
    
    protected $fillable = [
        'resident_id',
        'assistance_type',
        'amount',
        'date_granted',
        'remarks',
        'status',
        'approved_by',
        'geotag_id',
    ];

    protected $casts = [
        'date_granted' => 'date',
        'amount' => 'decimal:2',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'resident_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'approved_by', 'admin_id');
    }

    public function geoTag()
    {
        return $this->belongsTo(GeoTag::class, 'geotag_id', 'geotag_id');
    }
}
