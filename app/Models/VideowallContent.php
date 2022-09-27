<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideowallContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'lang', //['en', 'ar']
        'menu_id',
        'screen_id',
        'menu_order',
        'layout',
        'background_color',
        'text_color',
        'title',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }
}
