<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'name', 'whatsapp_number'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
