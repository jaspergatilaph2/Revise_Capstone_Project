<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedPlanFile extends Model
{
    protected $fillable = [
        'permit_application_id',
        'plan_name',
        'file_path',
        'deleted_by',
    ];

    protected $table = 'deleted_plans';

     public function permitApplication()
    {
        return $this->belongsTo(PermitApplication::class, 'permit_application_id');
    }
    use HasFactory;
}
