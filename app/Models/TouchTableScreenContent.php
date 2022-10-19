<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouchTableScreenContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'lang', //['en', 'ar']
        'menu_id',
        'screen_id',
        'menu_level',
        'background_color',
        'text_color',
        'title',
    ];
}
