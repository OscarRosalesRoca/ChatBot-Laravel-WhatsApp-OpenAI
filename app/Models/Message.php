<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'from',
        'message',
        'response',
        'status'
    ];
}
