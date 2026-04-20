<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Specify custom primary key
    protected $primaryKey = 'user_id';

    // Disable updated_at since you only have created_at
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'password',
        'role',
        'age',
        'civil_status',
        'id_type',
        'resident_id_file',
        'purok',
        'building_no',
        'barangay',
        'city',
        'full_address',
        'latitude',
        'longitude',
        'is_indigent',
        'purpose',
        'date_issued',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        // remove remember_token if not used
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'password' => 'hashed', // hashes automatically
    ];
}
