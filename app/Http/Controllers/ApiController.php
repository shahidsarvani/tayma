<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\VideowallContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function test()
    {
        return response()->json([
            "test" => "pass"
        ]);
    }

    //
    public function get_touchtable_main_menu()
    {
        $menus = Menu::where('screen_type', 'touchtable')->where('menu_id', 0)->orderBy('order', 'ASC')->get();
        $response = array();
        foreach ($menus as $menu) {
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'image_en' => asset('public/storage/media/' . $menu->image_en),
                'image_ar' => asset('public/storage/media/' . $menu->image_ar),
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_touchtable_footer_menu($menu_id)
    {
        $menus = Menu::where('screen_type', 'touchtable')->where('menu_id', $menu_id)->where('type', 'footer')->orderBy('order', 'ASC')->get();
        // return $menus;
        $response = array();
        foreach ($menus as $menu) {
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'icon_en' => asset('public/storage/media/' . $menu->icon_en),
                'icon_ar' => asset('public/storage/media/' . $menu->icon_ar),
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_touchtable_side_menu($menu_id)
    {
        $menus = Menu::where('screen_type', 'touchtable')->with(['children' => function ($q) {
            $q->orderBy('order', 'ASC');
        }])->where('menu_id', $menu_id)->where('type', 'side')->where('level', 1)->orderBy('order', 'ASC')->get();
        $response = array();
        foreach ($menus as $menu) {
            $temp = array();
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
            ];
            if ($menu->children) {
                foreach ($menu->children as $child) {
                    $sub_menu = array();
                    $sub_menu = [
                        'id' => $child->id,
                        'name_en' => $child->name_en,
                        'name_ar' => $child->name_ar,
                    ];
                    $temp['sub_menu'][] = $sub_menu;
                }
            }
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_touchtable_gallery($menu_id, $lang)
    {
        $mediaItems = Media::where('screen_type', 'touchtable')->where('menu_id', $menu_id)->where('lang', $lang)->orderBy('order', 'ASC')->get();
        // return $mediaItems;
        $response = array();
        foreach ($mediaItems as $key => $value) {
            $temp = [
                'id' => $value->id,
                'url' => asset('public/storage/media/' . $value->name),
                'type' => $value->type,
                'description' => $value->description
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_touchtable_content($menu_id, $lang)
    {

        $menu = Menu::with(['touch_screen_content' => function ($q) use ($lang) {
            $q->whereLang($lang);
        }, 'media' => function ($q) use ($lang) {
            $q->whereLang($lang);
        }])->find($menu_id);
        $response = array();
        if ($menu->touch_screen_content) {
            $response['menu_content'] = [
                'id' => $menu->touch_screen_content->id,
                'content' => $menu->touch_screen_content->content
            ];
        }
        if ($menu->media->isNotEmpty()) {
            foreach ($menu->media as $media) {
                $temp = [
                    'id' => $media->id,
                    'url' => asset('public/storage/media/' . $media->name),
                    'type' => $media->type
                ];
                $response['menu_content']['media'][] = $temp;
            }
        }

        return response()->json($response, 200);
    }

    public function get_videowall_main_menu()
    {
        $menu = Menu::where('screen_type', 'videowall')->where('menu_id', 0)->orderBy('order', 'ASC')->with('screen')->first();
/*        $content = [
            'id' => $menu->id,
            'name_en' => $menu->name_en,
            'name_ar' => $menu->name_ar,
            'menu_id' => $menu->menu_id,
            'level' => $menu->level,
            'type' => $menu->type,
            'screen' => [
                'id' => $menu->screen->id,
                'name_en' => $menu->screen->name_en,
                'name_ar' => $menu->screen->name_ar,
                'slug' => $menu->screen->slug,
                'screen_type' => $menu->screen->screen_type,
            ]
        ];
        $media = [
            'image_en' => $menu->image_en,
            'image_ar' => $menu->image_ar,
        ];

        return response()->json(array(
            'data' => array(
                'content' => $content,
                'media' => $media
            ),
        ), 200);*/
        $res = [];
        $res['en'] = [
            'id' => $menu->id,
            'screen_id' => $menu->screen->id,
            'name_en' => $menu->name_en,
            'image_en' => asset('public/storage/media/' . $menu->image_en),
        ];
        $res['ar'] = [
            'id' => $menu->id,
            'screen_id' => $menu->screen->id,
            'name_ar' => $menu->name_ar,
            'image_ar' => asset('public/storage/media/' . $menu->image_ar),
        ];
        return response()->json($res, 200);
    }

    public function get_videowall_footer_menu($menu_id)
    {
        $menus = Menu::where('screen_type', 'videowall')->where('menu_id', $menu_id)->where('type', 'footer')->orderBy('order', 'ASC')->get();
        // return $menus;
        $response = array();
        foreach ($menus as $menu) {
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'icon_en' => asset('public/storage/media/' . $menu->icon_en),
                'icon_ar' => asset('public/storage/media/' . $menu->icon_ar),
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_videowall_side_menu($menu_id)
    {
        $side_menu = Menu::where('screen_type', 'videowall')->with(['children' => function ($q) {
            $q->orderBy('order', 'ASC');
        }])->where('type', 'side')->where('level', 1)->orderBy('order', 'ASC')->limit(3)->get();

        $response['side_menu'] = $side_menu->map(function ($menu) {
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
            ];
            return $temp;
        })->toArray();
        $menus = Menu::where('screen_type', 'videowall')->where('id', 2)->with('screen')->get();
        $response['content'] = $menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'screen' => [
                    'id' => $menu->screen->id,
                ],
                'media' => [
                    'image_en' => $menu->image_en,
                    'image_ar' => $menu->image_ar,
                ]
            ];
        });

        /*     $response = array();
             foreach ($side_menu as $menu) {
                 $temp = array();
                 $temp = [
                     'id' => $menu->id,
                     'name_en' => $menu->name_en,
                     'name_ar' => $menu->name_ar,
                 ];
                 if ($menu->children) {
                     foreach ($menu->children as $child) {
                         $sub_menu = array();
                         $sub_menu = [
                             'id' => $child->id,
                             'name_en' => $child->name_en,
                             'name_ar' => $child->name_ar,
                         ];
                         $temp['sub_menu'][] = $sub_menu;
                     }
                 }
                 array_push($response, $temp);
             }*/
        return response()->json($response, 200);
    }

    public function getSideMenuContent()
    {
        $side_menu = Menu::where('screen_type', 'videowall')->with(['children' => function ($q) {
            $q->orderBy('order', 'ASC');
        }])->where('type', 'side')->where('level', 1)->orderBy('order', 'ASC')->limit(3)->get();
        $res = [];
        foreach ($side_menu as $menu) {
            $res['en'] = [
                'id' => $menu->id,
                'name' => $menu->name_en,
                'screen' => [
                    'id' => $menu->screen->id,
                ],
                'image' => $menu->image_en,
            ];
            $res['ar'] = [
                'id' => $menu->id,
                'name' => $menu->name_ar,
                'screen' => [
                    'id' => $menu->screen->id,
                ],
                'image' => $menu->image_ar,
            ];
        }

        $response['side_menu'] = $side_menu->map(function ($menu) {
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
            ];
            return $temp;
        })->toArray();
        $menus = Menu::where('screen_type', 'videowall')->where('id', 2)->with('screen')->get();
        $response['content'] = $menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'screen' => [
                    'id' => $menu->screen->id,
                ],
                'media' => [
                    'image_en' => $menu->image_en,
                    'image_ar' => $menu->image_ar,
                ]
            ];
        });

        /*     $response = array();
             foreach ($side_menu as $menu) {
                 $temp = array();
                 $temp = [
                     'id' => $menu->id,
                     'name_en' => $menu->name_en,
                     'name_ar' => $menu->name_ar,
                 ];
                 if ($menu->children) {
                     foreach ($menu->children as $child) {
                         $sub_menu = array();
                         $sub_menu = [
                             'id' => $child->id,
                             'name_en' => $child->name_en,
                             'name_ar' => $child->name_ar,
                         ];
                         $temp['sub_menu'][] = $sub_menu;
                     }
                 }
                 array_push($response, $temp);
             }*/
        return response()->json($res, 200);
    }

    public function get_videowall_gallery($menu_id, $lang)
    {
        $mediaItems = Media::where('screen_type', 'videowall')->where('menu_id', $menu_id)->where('lang', $lang)->orderBy('order', 'ASC')->get();
        // return $mediaItems;
        $response = array();
        foreach ($mediaItems as $key => $value) {
            $temp = [
                'id' => $value->id,
                'url' => asset('public/storage/media/' . $value->name),
                'type' => $value->type,
                'description' => $value->description
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_videowall_content($menu_id, $lang)
    {

        $menu = Menu::with(['videowall_content' => function ($q) use ($lang) {
            $q->whereLang($lang);
        }, 'media' => function ($q) use ($lang) {
            $q->whereLang($lang);
        }])->find($menu_id);
        // return $menu;
        $response = array();
        if ($menu->videowall_content) {
            $response['menu_content'] = [
                'id' => $menu->videowall_content->id,
                'content' => $menu->videowall_content->content
            ];
        }
        if ($menu->media->isNotEmpty()) {
            foreach ($menu->media as $media) {
                $temp = [
                    'id' => $media->id,
                    'url' => asset('public/storage/media/' . $media->name),
                    'type' => $media->type
                ];
                $response['menu_content']['media'][] = $temp;
            }
        }

        return response()->json($response, 200);
    }

    public function get_portrait_screen_videos($screen_id, $lang)
    {
        $media = Media::where('screen_type', 'portrait')->where('screen_slug', $screen_id)->where('lang', $lang)->get();

        $response = array();
        foreach ($media as $key => $value) {
            $temp = [
                'id' => $value->id,
                'url' => asset('public/storage/media/' . $value->name),
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    //-- API For Video Wall --//
    public function get_video_wall_screen_videos($screen_id, $lang)
    {
        $media = Media::where('screen_type', 'videowall')->where('screen_slug', $screen_id)->where('lang', $lang)->get();

        $response = array();
        foreach ($media as $key => $value) {
            $temp = [
                'id' => $value->id,
                'url' => asset('public/storage/media/' . $value->name),
            ];
            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function getMenuContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'screen' => 'required',
            'lang' => 'required|in:ar,en',
            'menuid' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        }

        $menus = Menu::where('id', $request->menuid)->where('screen_type', 'videowall')->with('children', 'media', 'screen', 'videowall_content')
            ->whereHas('screen', function ($q) use ($request) {
                $q->where('slug', $request->screen);
            })->first();
        $response = array();
        $media = array();
        $child = array();
        $content = $menus->videowall_content->content;
        $media = $menus->media->map(function ($media) {
            return env('APP_URL') . '/public/storage/media/' . $media->name;
        });

        return response()->json(array(
            'intro' => array(
                'content' => $content,
                'media' => $media
            ),
            'submenu' => $child,
        ), 200);
    }

    public function getMenuContentById($id): \Illuminate\Http\JsonResponse
    {
        $res = [];
        $menus = Menu::where('id', $id)->with('media')->get();

        $contents = VideowallContent::where('menu_id', $id)->with('media')->get();


        foreach ($contents as $content) {
            $res[$content->lang] = [
                'id' => $content->id,
                'content' => $content->content,
                'background_color' => $content->background_color,
                'text_color' => $content->text_color,
                'title' => $content->title,
                'screen_id' => $content->screen_id,
                'media' => $content->media->map(function ($media) use ($content) {
                    if ($media->lang == $content->lang)
                        return env('APP_URL') . '/public/storage/media/' . $media->name;
                })
            ];
        }

        return response()->json(array(
            'data' => $res
        ), 200);
    }

    //-- /API For Video Wall --//
}
