<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'document_id';
    
    protected $fillable = [
        'request_id',
        'document_type',
        'issued_date',
        'file_path',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class, 'request_id', 'request_id');
    }

    public function certificateOfIndigency()
    {
        return $this->hasOne(CertificateOfIndigency::class, 'document_id', 'document_id');
    }
}
