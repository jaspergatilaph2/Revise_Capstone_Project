<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsHistory extends Model
{
    protected $fillable = ['user_id' , 'description'];
    protected $table = 'logs_history';
    use HasFactory;
}
