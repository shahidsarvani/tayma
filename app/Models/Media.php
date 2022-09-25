<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'type',
        'order',
        'description',
        'lang', //['en', 'ar']
        'screen_type', //['portrait', 'videowall', 'withrfid', 'touchtable']);
        'screen_slug',
        'menu_id',
    ];

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
