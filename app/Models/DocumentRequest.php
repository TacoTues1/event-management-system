<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_requests';
    protected $primaryKey = 'request_id';
    
    protected $fillable = [
        'resident_id',
        'purpose',
        'request_date',
        'status',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id', 'user_id');
    }

    public function document()
    {
        return $this->hasOne(Document::class, 'request_id', 'request_id');
    }
}
