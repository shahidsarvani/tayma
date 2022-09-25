<?php

namespace App\Models;

use App\Enums\EnumGeneral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'is_touch',
        'is_rfid',
        'is_model',
        'screen_type', //['portrait', 'videowall', 'withrfid', 'touchtable']);
    ];

    public static function get_enums($columnName)
    {
        return EnumGeneral::getEnumValues('screens',$columnName);
    }

}
