<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'branch',
        'is_payment',
        'is_deposit'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
