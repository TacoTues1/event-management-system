<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Specify the table name if different from default (optional)
    protected $table = 'events';

    // Primary key (optional if using default 'id')
    protected $primaryKey = 'event_id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'latitude',
        'longitude',
        'event_type',
    ];
}
