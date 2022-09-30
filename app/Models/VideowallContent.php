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
        'menu_level',
        'layout',
        'background_color',
        'text_color',
        'title',
        'text_bg_img',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function media() {
        return $this->hasMany(Media::class, 'menu_id', 'menu_id');
    }
}
