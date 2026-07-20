<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'device_name',
        'user_agent',
        'custom_name',
        'last_accessed_at'
    ];
}
