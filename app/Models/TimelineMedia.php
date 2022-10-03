<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'timeline_item_id',
        'name',
        'type',
        'order',
        'description',
        'lang', //['en', 'ar']
        'menu_id',
    ];
}
