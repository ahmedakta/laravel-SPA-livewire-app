<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['message','user_id'];
    use HasFactory;
    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
