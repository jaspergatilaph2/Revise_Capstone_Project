<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlumbingPlan extends Model
{

    protected $fillable = [
        'permit_application_id',
        'plan_name',
        'description',
        'documents',
        'reviewed_by',
        'status',
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    protected $table = 'plumbing_plan';

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
