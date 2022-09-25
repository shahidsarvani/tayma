<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_en',
        'image_ar',
        'content_en',
        'content_ar',
        'sort_order',
        'rfid_card_id',
        'is_active',
    ];

    public function card()
    {
        return $this->belongsTo(RfidCard::class, 'rfid_card_id');
    }
}
