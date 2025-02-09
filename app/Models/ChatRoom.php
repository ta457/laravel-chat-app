<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'room_code'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chatRoom) {
            $chatRoom->room_code = Str::random(10);
        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_user');
    }
}