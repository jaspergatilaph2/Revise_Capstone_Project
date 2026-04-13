<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalPlans extends Model
{
    protected $fillable = [
        'permit_application_id',
        'plan_name',
        'description',
        'documents',
        'reviewed_by',
        'status',
        'created_at',
        'updated_at',
        'rejected_by',
        'rejection_comment',
        'archived'
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    protected $table = 'electrical_plan';

    public function permitApplication()
    {
        return $this->belongsTo(PermitApplication::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    use HasFactory;
}
