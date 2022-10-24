<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouchScreenContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'lang', //['en', 'ar']
        'menu_id',
        'title',
        'sub_title',
        'menu_level',
        'layout',
        'background_color',
        'text_color',
        'text_bg_image',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }


    public function media()
    {
        return $this->hasMany(Media::class, 'menu_id', 'menu_id');
    }
}
