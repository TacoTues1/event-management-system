<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateOfIndigency extends Model
{
    use HasFactory;

    protected $table = 'certificate_of_indigency';
    protected $primaryKey = 'certificate_id';
    
    protected $fillable = [
        'document_id',
        'validity_date',
    ];

    protected $casts = [
        'validity_date' => 'date',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'document_id');
    }
}
