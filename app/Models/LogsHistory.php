<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsHistory extends Model
{
    protected $fillable = ['user_id', 'description'];
    protected $table = 'logs_history';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // assuming logs table has user_id column
    }
    use HasFactory;
}
