<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchitecturalPlan extends Model
{
    protected $fillable = [
        'permit_application_id',
        'plan_name',
        'description',
        'file_path'
    ];

    protected $table = 'architectural_plans';

    protected $casts = [
        'file_path' => 'array',
    ];


    public function permitApplication()
    {
        return $this->belongsTo(PermitApplication::class);
    }
    use HasFactory;
}
