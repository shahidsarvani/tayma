<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test',[ApiController::class,'test']);
Route::get('logo',[ApiController::class,'getSiteLogo']);

Route::prefix('touchtable')->group(function() {
    Route::get('main_menu', [ApiController::class, 'get_touchtable_main_menu']);
    Route::get('side_menu/{menu_id}', [ApiController::class, 'get_touchtable_side_menu']);
    Route::get('footer_menu/{menu_id}', [ApiController::class, 'get_touchtable_footer_menu']);
    Route::get('media/{menu_id}/{lang}', [ApiController::class, 'get_all_media']);
    Route::get('gallery/{menu_id}/{lang}', [ApiController::class, 'get_touchtable_gallery']);
    Route::get('content/{menu_id}', [ApiController::class, 'get_touchtable_content']);
});

Route::prefix('touchtablescreen')->group(function() {
    Route::get('main_menu', [ApiController::class, 'get_touchtablescreen_main_menu']);
    Route::get('side_menu/{menu_id}', [ApiController::class, 'get_touchtablescreen_side_menu']);
    Route::get('timeline/menu/{id}', [ApiController::class, 'get_menu_detail']);

});

Route::prefix('videowall')->group(function() {
    Route::get('main_menu', [ApiController::class, 'get_videowall_main_menu']);
    Route::get('side/menu/content', [ApiController::class, 'getSideMenuContent']);
    Route::get('menu/content/{id}', [ApiController::class, 'getSideMenuContentById']);
    Route::get('menu/content/{id}/gallery', [ApiController::class, 'getFirstGalleryById']);
    Route::get('side_menu/{menu_id}', [ApiController::class, 'get_videowall_side_menu']);
    Route::get('footer_menu/{menu_id}', [ApiController::class, 'get_videowall_footer_menu']);
    Route::get('gallery/{menu_id}/{lang}', [ApiController::class, 'get_videowall_gallery']);
    Route::get('content/{menu_id}/{lang}', [ApiController::class, 'get_videowall_content']);
    Route::get('menu/content', [ApiController::class, 'getMenuContent']);
    Route::get('menu/side/content/{id}', [ApiController::class, 'getMenuContentById']);
    Route::get('layout', [ApiController::class, 'getLayout']);
});

Route::get('portrait_screen_videos/{screen_id}/{lang}', [ApiController::class, 'get_portrait_screen_videos']);
Route::get('video_wall_screen_videos/{lang}', [ApiController::class, 'get_video_wall_screen_videos']);
Route::get('portrait/video/{slug}/{lang}', [ApiController::class, 'getVideoByPortraitScreenSlugLang']);
