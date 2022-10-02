<?php

namespace App\Models;

use App\Enums\EnumGeneral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'menu_id',
        'level',
        'type',
        'icon_en',
        'icon_ar',
        'image_en',
        'image_ar',
        'is_active',
        'order',
        'screen_type', //['portrait', 'videowall', 'withrfid', 'touchtable']);
        'screen_id',
        'bg_image',
        'is_timeline',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_id');
    }

    public static function get_enums($columnName)
    {
        return EnumGeneral::getEnumValues('screens', $columnName);
    }

    public function touch_screen_content()
    {
        return $this->hasOne(TouchScreenContent::class);
    }

    public function touch_screen_timeline()
    {
        return $this->hasMany(TimelineItem::class);
    }

    public function videowall_content()
    {
        return $this->hasOne(VideowallContent::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function get_timeline_items($menu_id, $lang)
    {
        $items = TimelineItem::with(['timeline_media' => function ($q) use ($lang) {
            $q->whereLang($lang);
        }])->where('menu_id', $menu_id)->where('lang', $lang)->get();
        $response = array();
        if ($items) {
            foreach ($items as $item) {
                $temp = array();
                $temp['item'] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                ];
                if ($item->timeline_media->isNotEmpty()) {
                    foreach ($item->timeline_media as $media) {
                        $temp2 = [
                            'id' => $media->id,
                            'url' => asset('public/storage/media/' . $media->name),
                            'type' => $media->type
                        ];
                        $temp['item']['media'][] = $temp2;
                    }
                }
                array_push($response, $temp);
            }
        }
        return $response;
    }
}
