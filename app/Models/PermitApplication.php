<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitApplication extends Model
{
    protected $fillable = [
        'user_id',
        'project_name',
        'location',
        'address',       // NEW
        'latitude',      // NEW
        'longitude',     // NEW
        'radiusRange',   // NEW
        'project_cost',  // NEW
        'description',
        'documents',
        'status',
        'avatar',
        'seen',
        'images'
    ];
    protected $casts = [
        'documents' => 'array', // Automatically cast JSON to array
        'seen' => 'boolean',
    ];

    protected $table = "permit_applications";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    use HasFactory;
}
