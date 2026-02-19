<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructuralPlan extends Model
{
    protected $fillable = [
        'permit_application_id',
        'plan_name',
        'description',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    public function permitApplication()
    {
        return $this->belongsTo(PermitApplication::class);
    }
    use HasFactory;
}
