<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use App\Models\Setting;
use App\Models\TimelineItem;
use App\Models\TouchScreenContent;
use App\Models\TouchTableScreenContent;
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
        $menus = Menu::where('screen_type', 'touchtable')->where('menu_id', 0)->with('media')->orderBy('order', 'ASC')->get();
        $contents = TouchScreenContent::whereIn('menu_id', $menus->pluck('id')->toArray())->with('media')->get();

        $response = array();
        foreach ($menus as $menu) {
            $response[] = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
                'content' => [
                    'ar' => $contents->map(function ($c) use ($menu) {
                        if ($c->lang == 'ar' && $c->menu_id == $menu->id) {
                            return [
                                'name' => $menu->name_ar,
                                'content' => $c->content,
                                'media' => $c->media->map(function ($med) {
                                    if ($med->lang == 'en')
                                        return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                                })->filter()->values(),
                            ];
                        }
                    })->filter()->values(),
                    'en' => $contents->map(function ($c) use ($menu) {
                        if ($c->lang == 'en' && $c->menu_id == $menu->id) {
                            return [
                                'name' => $menu->name_en,
                                'content' => $c->content,
                                'media' => $c->media->map(function ($med) {
                                    if ($med->lang == 'ar')
                                        return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                                })->filter()->values(),
                            ];
                        }
                    })->filter()->values(),
                ],
                'image_en' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_en,
                'image_ar' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_ar,
                'media' => $menu->media->map(function ($med) {
                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                }),
            ];
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
            $q->orderBy('order', 'ASC')->with('touch_screen_content');
        }])->where('menu_id', $menu_id)->where('type', 'side')->where('level', 1)->orderBy('order', 'ASC')
            ->with('touch_screen_content', 'media')
            ->get();

        $response = array();
        foreach ($menus as $menu) {
            $response['en'][] = [
                'id' => $menu->id,
                'name' => $menu->name_en,
                'content' => $menu->touch_screen_content ? $menu->touch_screen_content->content : null,
                'media' => $menu->media->map(function ($med) {
                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                }),
                'child' => $menu->children->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'name' => $m->name_en,
                        'content' => !!$m->touch_screen_content ? $m->touch_screen_content->content : null,
                        'media' => $m->media->map(function ($med) {
                            return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                        }),
                    ];
                })
            ];
            $response['ar'][] = [
                'id' => $menu->id,
                'name' => $menu->name_ar,
                'content' => $menu->touch_screen_content->content,
                'media' => $menu->media->map(function ($med) {
                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                }),
                'child' => $menu->children->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'name' => $m->name_en,
                        'content' => !!$m->touch_screen_content ? $m->touch_screen_content->content : null,
                        'media' => $m->media->map(function ($med) {
                            return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                        }),
                    ];
                })
            ];
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
//            array_push($response, $temp);
        }
        return response()->json($response, 200);
    }

    public function get_all_media($menu_id, $lang)
    {
        $menus = Menu::where('menu_id', $menu_id)->get()->pluck('id')->toArray();
        $mediaItems = Media::whereIn('menu_id', $menus)->where('screen_type', 'touchtable')->where('lang', $lang)->orderBy('order', 'ASC')->get();
        // return $mediaItems;
        $response = array();
        foreach ($mediaItems as $key => $value) {
            $temp = [
                'id' => $value->id,
                'path' => env('APP_URL') . '/storage/app/public/media/' . $value->name,
                'type' => $value->type,
                'description' => $value->description
            ];
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

    public function get_touchtable_content($menu_id)
    {

        $menu = Menu::where('id', $menu_id)->first();
        $contents = TouchScreenContent::where('menu_id', $menu_id)->with('media')->get();
        $response = array();
        foreach ($contents as $content) {
            $response[$content->lang] = [
                'id' => $menu->id,
                'content' => $content->content,
                'name' => $content->lang == 'ar' ? $menu->name_ar : $menu->name_en,
                'media' => $content->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'type' => $media->type,
                        'path' => env('APP_URL') . '/storage/app/public/media/' . $media->name,
                    ];
                })
            ];
        }

        return response()->json($response, 200);
    }

    public function get_videowall_main_menu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'screen' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        }

        $menus = Menu::where('screen_type', 'videowall')->where('menu_id', 0)->whereHas('screen', function ($query) {
            $query->where('slug', \request()->screen);
        })->orderBy('order', 'ASC')->with('screen')->get();
        $res = [];
        foreach ($menus as $menu) {
            $res['en'][] = [
                'id' => $menu->id,
                'screen_id' => $menu->screen->id,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
                'bg_video' => !!$menu->bg_video ? env('APP_URL') . '/storage/app/public/media/' . $menu->bg_video : null,
                'name' => $menu->name_en,
                'image' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_en,
            ];
            $res['ar'][] = [
                'id' => $menu->id,
                'screen_id' => $menu->screen->id,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
                'bg_video' => !!$menu->bg_video ? env('APP_URL') . '/storage/app/public/media/' . $menu->bg_video : null,
                'name' => $menu->name_ar,
                'image' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_ar,
            ];
        }

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
                'icon_en' => env('APP_URL') . '/storage/app/public/media/' . $menu->icon_en,
                'icon_ar' => env('APP_URL') . '/storage/app/public/media/' . $menu->icon_ar,
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

    public function getSideMenuContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'screen' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        }

        $side_menu = Menu::where('screen_type', 'videowall')->where('type', 'side')->where('level', 1)->whereHas('screen', function ($query) {
            $query->where('slug', \request()->screen);
        })->with('screen', 'videowall_content')->orderBy('order', 'ASC')->get();
        $contents = VideowallContent::where('menu_id', 1)->with('media', 'screen')->get();


        $res = [];
        foreach ($side_menu as $menu) {
            $res['en']['sideMenu'][] = [
                'id' => $menu->id,
                'name' => $menu->name_en,
                'screen_id' => $menu->screen->id,
                'screen' => $menu->screen->name_en,
                'image' => $menu->image_en,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
            ];
            $res['ar']['sideMenu'][] = [
                'id' => $menu->id,
                'name' => $menu->name_ar,
                'screen_id' => $menu->screen->id,
                'screen' => $menu->screen->name_ar,
                'image' => $menu->image_ar,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
            ];
        }

        foreach ($contents as $content) {
            if ($content->lang === 'en') {
                $res['en']['content'] = [
                    'id' => $content->id,
                    'name' => $content->content,
                    'screen_id' => $content->screen->id,
                    'screen' => $content->screen->name_en,
                    'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                    'media' =>
                        $content->media->map(function ($media) {
                            return env('APP_URL') . '/storage/app/public/media/' . $media->name;
                        }),
                ];
            }
            if ($content->lang === 'ar') {
                $res['ar']['content'] = [
                    'id' => $content->id,
                    'name' => $content->content,
                    'screen_id' => $content->screen->id,
                    'screen' => $content->screen->name_ar,
                    'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                    'media' =>
                        $content->media->map(function ($media) {
                            return env('APP_URL') . '/storage/app/public/media/' . $media->name;
                        }),
                ];
            }
        }

        return response()->json($res, 200);
    }

    public function getSideMenuContentById($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'screen' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        }
        $contents = VideowallContent::where('menu_id', $id)->with('menu', 'screen', 'media')->get();
        $menuu = Menu::where('id', $id)->first();
        $child_menus = Menu::where('menu_id', $id)->where('level', 1)->whereHas('screen', function ($query) {
            $query->where('slug', \request()->screen);
        })->with('screen', 'videowall_content')->with('children')->orderBy('order', 'ASC')->get();

        $res = [];
        foreach ($child_menus as $menu) {
            $children = [];
            if (count($menu->children) > 0) {
                foreach ($menu->children as $child)
                    $children[] = [
                        'id' => $child->id,
                        'name' => $child->name_en,
                        'screen_id' => $menu->screen->id,
                        'screen' => $menu->screen->name_en,
                        'image' => $child->image_en,
                        'child_menus' => $child->children->toArray(),
                        'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $child->bg_image,
                        'intro_video' => [
                            'type' => 'video',
                            'path' => env('APP_URL') . '/storage/app/public/media/' . $child->intro_video
                        ],
                    ];
            }
            $res['en']['menus'][] = [
                'id' => $menu->id,
                'name' => $menu->name_en,
                'screen_id' => $menu->screen->id,
                'screen' => $menu->screen->name_en,
                'image' => $menu->image_en,
                'child' => $children,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
                'intro_video' => [
                    'type' => 'video',
                    'path' => env('APP_URL') . '/storage/app/public/media/' . $menu->intro_video
                ],
            ];
            $res['ar']['menus'][] = [
                'id' => $menu->id,
                'name' => $menu->name_ar,
                'screen_id' => $menu->screen->id,
                'screen' => $menu->screen->name_ar,
                'image' => $menu->image_ar,
                'child' => $children,
                'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
                'intro_video' => [
                    'type' => 'video',
                    'path' => env('APP_URL') . '/storage/app/public/media/' . $menu->intro_video
                ],
            ];
        }

        foreach ($contents as $content) {
            if ($content->lang === 'en') {
                $res['en']['content'] = [
                    'id' => $content->id,
                    'title' => $content->title,
                    'menu_name' => $menuu->name_en,
                    'intro_video' => collect(json_decode($menuu->intro_video))->map(function ($media) {
                        return [
                            'type' => 'video',
                            'path' => env('APP_URL') . '/storage/app/public/media/' . $media
                        ];
                    }),
                    'content' => $content->content,
                    'screen_id' => $content->screen->id,
                    'screen' => $content->screen->name_en,
                    'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                    'media' =>
                        $content->media->map(function ($media) {
                            if ($media->lang == 'en')
                                return [
                                    'type' => $media->type,
                                    'path' => env('APP_URL') . '/storage/app/public/media/' . $media->name
                                ];
                        })->filter()->values(),
                ];
            }
            if ($content->lang === 'ar') {
                $res['ar']['content'] = [
                    'id' => $content->id,
                    'title' => $content->title,
                    'menu_name' => $menuu->name_ar,
                    'intro_video' => collect(json_decode($menuu->intro_video))->map(function ($media) {
                        return [
                            'type' => 'video',
                            'path' => env('APP_URL') . '/storage/app/public/media/' . $media
                        ];
                    }),
                    'content' => $content->content,
                    'screen_id' => $content->screen->id,
                    'screen' => $content->screen->name_ar,
                    'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                    'media' =>
                        $content->media->map(function ($media) {
                            if ($media->lang == 'ar')
                                return [
                                    'type' => $media->type,
                                    'path' => env('APP_URL') . '/storage/app/public/media/' . $media->name
                                ];
                        })->filter()->values(),
                ];
            }
        }

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
    public function get_video_wall_screen_videos($lang)
    {
        $screen = Screen::where('is_touch', 0)->get()->pluck('slug')->toArray();
        $media = Media::whereIn('screen_slug', $screen)->where('lang', $lang)->get();
        $response = array();
        foreach ($media as $key => $value) {
            if (!!$value)
                $response[] = env('APP_URL') . '/storage/app/public/media/' . $value->name;
        }
        return stripslashes(json_encode($response));
        return $response;
        return response()->json($response, 200);
    }

    //-- API For Video Wall --//
    public function getVideoByPortraitScreenSlugLang($slug, $lang)
    {
        $screen = Screen::where('slug', $slug)->where('screen_type', 'portrait')->get()->pluck('slug')->toArray();
        $media = Media::whereIn('screen_slug', $screen)->where('lang', $lang)->where('screen_type', 'portrait')->get();
        $response = array();
        foreach ($media as $key => $value) {
            if (!!$value)
                $response[] = env('APP_URL') . '/storage/app/public/media/' . $value->name;
        }
        return stripslashes(json_encode($response));
        return $response;
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
            return env('APP_URL') . '/storage/app/public/media/' . $media->name;
        });

        return response()->json(array(
            'intro' => array(
                'content' => $content,
                'media' => $media
            ),
            'submenu' => $child,
        ), 200);
    }

    public function getMenuContentById(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $res = [];
        $menu = Menu::where('menu_id', $id)->get()->pluck('id')->toArray();
        $contents = VideowallContent::whereIn('menu_id', $menu)->with('media', 'screen', 'menu')->whereHas('screen', function ($query) {
            $query->where('slug', \request()->screen);
        })->orderBy(Menu::select('order')->whereColumn('menus.menu_id', 'videowall_contents.menu_id'), 'DESC')
            ->get();

        foreach ($contents as $content) {
            $res[] = [
                'id' => $content->id,
                'lang' => $content->lang,
                'layout' => $content->layout,
                'content' => $content->content,
                'background_color' => $content->background_color,
                'text_color' => $content->text_color,
                'title' => $content->title,
                'screen_id' => $content->screen_id,
                'screen' => $content->screen['name_' . $content->lang],
                'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                'media' => $content->media->map(function ($media) use ($content) {
                    if ($media->lang == $content->lang && !!$media->name) {
                        return [
                            'link' => env('APP_URL') . '/storage/app/public/media/' . $media->name,
                            'type' => $media->type,
                            'lang' => $media->lang,
                        ];
                    }
                })->filter()->values(),
            ];
        }
        return response()->json($res, 200);
    }

    public function getLayout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layout' => 'required',
            'screen' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        } else {
            $screen = Screen::where('slug', $request->screen)->first();
            $videoWall = VideowallContent::where('layout', $request->layout)->where('screen_id', $screen->id)->with('media')->get();
            foreach ($videoWall as $item) {
                if ($item->lang === 'en') {
                    $res['en'] = array(
                        'id' => $item->id,
                        'title' => $item->title,
                        'content' => $item->content,
                        'screen_id' => $item->screen_id,
                        'layout' => $item->layout,
                        'background_color' => $item->background_color,
                        'text_color' => $item->text_color,
                        'media' =>
                            $item->media->map(function ($media) {
                                if ($media->lang === 'en')
                                    return env('APP_URL') . '/storage/app/public/media/' . $media->name;
                            })->filter()->values(),
                    );
                }
                if ($item->lang === 'ar') {
                    $res['ar'] = array(
                        'id' => $item->id,
                        'title' => $item->title,
                        'content' => $item->content,
                        'screen_id' => $item->screen_id,
                        'layout' => $item->layout,
                        'background_color' => $item->background_color,
                        'text_color' => $item->text_color,
                        'media' =>
                            $item->media->map(function ($media) {
                                if ($media->lang === 'ar')
                                    return env('APP_URL') . '/storage/app/public/media/' . $media->name;
                            })->filter()->values(),
                    );
                }
            }
            return response()->json($res, 200);
        }
    }

    public function getSiteLogo(Request $request)
    {
        $logo = Setting::where('key', 'logo')->first();
        $logo = $logo ? env('APP_URL') . '/storage/app/public/media/' . $logo->value : env('APP_URL') . '/assets/global_assets/images/placeholders/placeholder.jpg';
        return response()->json($logo);
    }

    public function getFirstGalleryById($id)
    {
        $menu = Menu::where('menu_id', $id)->get()->pluck('id')->toArray();
        $media = Media::whereIn('menu_id', $menu)->with('menu')->get();
        $gallery = [];
        foreach ($media as $m) {
            $gallery['en'][$m->menu->name_en][] = [
                'path' => env('APP_URL') . '/storage/app/public/media/' . $m->name,
                'type' => $m->type
            ];
            $gallery['ar'][$m->menu->name_ar][] = [
                'path' => env('APP_URL') . '/storage/app/public/media/' . $m->name,
                'type' => $m->type
            ];
        }
        return \response()->json($gallery);
    }


    public function get_touchtablescreen_main_menu()
    {
        $menu = Menu::where('screen_type', 'touchtable')->where('menu_id', 0)->with('media')->first();
        $contents = TouchScreenContent::where('menu_id', $menu->id)->with('media')->get();
        $response = [
            'id' => $menu->id,
            'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
            'name_en' => $menu->name_en,
            'name_ar' => $menu->name_ar,
            'content' => [
                'ar' => $contents->map(function ($c) use ($menu) {
                    if ($c->lang == 'ar' && $c->menu_id == $menu->id) {
                        return [
                            'name' => $menu->name_ar,
                            'content' => $c->content,
                            'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->text_bg_image,
                            'media' => $c->media->map(function ($med) {
                                if ($med->lang == 'en')
                                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                            })->filter()->values(),
                        ];
                    }
                })->filter()->values(),
                'en' => $contents->map(function ($c) use ($menu) {
                    if ($c->lang == 'en' && $c->menu_id == $menu->id) {
                        return [
                            'name' => $menu->name_en,
                            'content' => $c->content,
                            'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->text_bg_image,
                            'media' => $c->media->map(function ($med) {
                                if ($med->lang == 'ar')
                                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                            })->filter()->values(),
                        ];
                    }
                })->filter()->values(),
            ],
            'image_en' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_en,
            'image_ar' => env('APP_URL') . '/storage/app/public/media/' . $menu->image_ar,
            'media' => $menu->media->map(function ($med) {
                return env('APP_URL') . '/storage/app/public/media/' . $med->name;
            }),
        ];
        return response()->json($response, 200);
    }

    public function get_touchtablescreen_side_menu($menu_id)
    {
        $menus = Menu::where('screen_type', 'touchtable')->where('menu_id', $menu_id)->where('type', 'side')->where('level', 1)->orderBy('order', 'ASC')
            ->with('touch_screen_content', 'media')
            ->get();

        $response = array();
        foreach ($menus as $menu) {
            $response['en'][] = [
                'id' => $menu->id,
                'name' => $menu->name_en,
                'content' => $menu->touch_screen_content ? $menu->touch_screen_content->content : null,
                'media' => $menu->media->map(function ($med) {
                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                }),
            ];
            $response['ar'][] = [
                'id' => $menu->id,
                'name' => $menu->name_ar,
                'content' => $menu->touch_screen_content->content ?? null,
                'media' => $menu->media->map(function ($med) {
                    return env('APP_URL') . '/storage/app/public/media/' . $med->name;
                }),
            ];
            $temp = array();
            $temp = [
                'id' => $menu->id,
                'name_en' => $menu->name_en,
                'name_ar' => $menu->name_ar,
            ];
        }
        return response()->json($response, 200);
    }

    public function get_menu_detail(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $res = [];
        $menu = Menu::where('id', $id)->with('touch_screen_content', 'media')->first();
        $menus = Menu::where('menu_id', $id)
//            ->where('is_timeline', true)
            ->get();
        $contents = TouchScreenContent::whereIn('menu_id', $menus->pluck('id')->toArray())->with('media', 'menu')->get();
//        dd($contents, $menus, $id);
        foreach ($contents as $content) {
            $menu = $menus->first(function($item) use ($content) {
                return $item->id == $content->menu_id;
            });

            $res[$content->lang]['timeline'][] = [
                'id' => $content->id,
                'is_timeline' => $menu->is_timeline,
                'lang' => $content->lang,
                'layout' => $content->layout,
                'content' => $content->content,
                'background_color' => $content->background_color,
                'text_color' => $content->text_color,
                'title' => $content->lang === 'en' ? $content->menu->name_en : $content->menu->name_ar,
                'screen_id' => $content->screen_id,
                'text_bg_image' => env('APP_URL') . '/storage/app/public/media/' . $content->text_bg_image,
                'media' => $content->media->map(function ($media) use ($content) {
                    if ($media->lang == $content->lang && !!$media->name) {
                        return [
                            'link' => env('APP_URL') . '/storage/app/public/media/' . $media->name,
                            'type' => $media->type,
                            'lang' => $media->lang,
                        ];
                    }
                })->filter()->values(),
            ];
        }
        $res['en']['content'] = [
            'name' => $menu->name_en,
            'is_timeline' => $menu->is_timeline,
            'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
            'screen_type' => $menu->screen_type,
            'content' => $menu->touch_screen_content->content ?? null,
            'media' => $menu->media->map(function ($med) {
                if ($med->lang == 'en') {
                    return [
                        'link' => env('APP_URL') . '/storage/app/public/media/' . $med->name,
                        'type' => $med->type,
                        'lang' => $med->lang,
                    ];
                }
            })->filter()->values(),
        ];
        $res['ar']['content'] = [
            'name' => $menu->name_ar,
            'is_timeline' => $menu->is_timeline,
            'bg_image' => env('APP_URL') . '/storage/app/public/media/' . $menu->bg_image,
            'screen_type' => $menu->screen_type,
            'content' => $menu->touch_screen_content->content ?? null,
            'media' => $menu->media->map(function ($med) {
                if ($med->lang == 'ar') {
                    return [
                        'link' => env('APP_URL') . '/storage/app/public/media/' . $med->name,
                        'type' => $med->type,
                        'lang' => $med->lang,
                    ];
                }
            })->filter()->values(),
        ];
        return response()->json($res, 200);
    }


    //-- /API For Video Wall --//
}
