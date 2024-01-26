<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    public function sender()
    {
        return $this->belongsTo(User::class, 'send_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'send_to');
    }
}
