<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Card;
use App\Models\Terminal;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_datetime',
        'terminal_id',
        'card_id',
        'nominal'
    ];
    public function terminal()
    {
        return $this->hasOne(Terminal::class, 'id', 'terminal_id');
    }
    public function card()
    {
        return $this->hasOne(Card::class, 'id', 'card_id');
    }
}
