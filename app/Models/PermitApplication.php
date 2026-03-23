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
        'images',
        'reviewed_by'
    ];
    protected $casts = [
        'documents' => 'array', // Automatically cast JSON to array
        'seen' => 'boolean',
        'document_urls' => 'array',
        'plan_files' => 'array',
        'structural_plan_files' => 'array',
        'electrical_plan_files' => 'array',
        'plumbing_plan_files' => 'array',
    ];

    protected $table = "permit_applications";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function architecturalPlans()
    {
        return $this->hasMany(ArchitecturalPlan::class, 'permit_application_id');
    }

    public function structuralPlans()
    {
        return $this->hasMany(StructuralPlan::class, 'permit_application_id');
    }

    public function electricalPlans()
    {
        return $this->hasMany(ElectricalPlans::class, 'permit_application_id');
    }

    public function plumbingPlan()
    {
        return $this->hasMany(PlumbingPlan::class, 'permit_application_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // PermitApplication.php
    // public function architecturalPlan()
    // {
    //     return $this->hasOne(ArchitecturalPlan::class, 'permit_application_id');
    // }

    use HasFactory;
}
