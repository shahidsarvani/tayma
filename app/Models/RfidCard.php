<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'card_id',
        'is_active',
    ];

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }
}
