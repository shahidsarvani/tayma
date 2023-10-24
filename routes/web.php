<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RfidCardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortraitScreenController;
use App\Http\Controllers\PortraitScreenMediaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TouchScreenContentController;
use App\Http\Controllers\TouchScreenMediaController;
use App\Http\Controllers\TouchScreenMenuController;
use App\Http\Controllers\TouchScreenTimelineItemController;
use App\Http\Controllers\VideoWallContentController;
use App\Http\Controllers\VideoWallGalleryController;
use App\Http\Controllers\VideoWallMediaController;
use App\Http\Controllers\VideoWallMenuController;
use App\Http\Controllers\VideoWallScreenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/linkstorage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fonts', [SettingController::class, 'fonts'])->name('fonts');
    Route::delete('media/{id}', [PortraitScreenMediaController::class, 'portrait_video_delete'])->name('media.delete');

    Route::get('permissions/crud_create', [PermissionController::class, 'crud_create'])->name('permissions.crud_create');
    Route::post('permissions/crud_store', [PermissionController::class, 'crud_store'])->name('permissions.crud_store');
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('screens', ScreenController::class);
    Route::resource('cards', RfidCardController::class);
    Route::resource('slides', SlideController::class);
    Route::resource('layouts', LayoutController::class);
    Route::resource('hardwares', \App\Http\Controllers\HardwareController::class);
    Route::resource('schedule', \App\Http\Controllers\HardwareScheduleController::class);

    Route::prefix('touchtable-screen')->name('touchtable.')->group(function () {
        Route::resource('screens', \App\Http\Controllers\TouchTableScreenController::class);
        Route::resource('menus', TouchScreenMenuController::class);
        Route::get('content/edit/{id}', [TouchScreenContentController::class, 'edit']);
        Route::resource('content', TouchScreenContentController::class);
        Route::resource('timeline', TouchScreenTimelineItemController::class);
        Route::controller(TouchScreenMediaController::class)->group(function () {
            Route::get('media', 'touchtable_media_index')->name('media.index');
            Route::get('media/create', 'touchtable_media_create')->name('media.create');
            Route::post('media', 'touchtable_media_store')->name('media.store');
            Route::get('media/{id}/edit', 'touchtable_media_edit')->name('media.edit');
            Route::put('media/{id}', 'touchtable_media_update')->name('media.update');
            Route::delete('media/{id}', 'touchtable_media_delete')->name('media.delete');
        });
        Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
        Route::get('getscreensidemenu/{screen_id}', [VideoWallScreenController::class, 'getscreensidemenu'])->name('getscreensidemenu');
    });
    Route::prefix('portrait-screen')->name('portrait.')->group(function () {
        Route::resource('screens', PortraitScreenController::class);
        Route::get('media', [PortraitScreenMediaController::class, 'portrait_video_index'])->name('media.index');
        Route::get('media/create', [PortraitScreenMediaController::class, 'portrait_video_create'])->name('media.create');
        Route::post('media', [PortraitScreenMediaController::class, 'portrait_video_store'])->name('media.store');
        Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
    });

    //-------- Video Wall Screen --------//
    Route::prefix('video-wall-screen')->name('videowall.')->group(function () {
        Route::resource('screens', VideoWallScreenController::class);
        Route::get('getscreenmainmenu/{screen_id}', [VideoWallScreenController::class, 'getscreenmainmenu'])->name('getscreenmainmenu');
        Route::get('getscreensidemenu/{screen_id}', [VideoWallScreenController::class, 'getscreensidemenu'])->name('getscreensidemenu');
        Route::resource('content', VideoWallContentController::class);
        Route::resource('menus', VideoWallMenuController::class);
        Route::get('menu/bg/remove/{id}', [VideoWallMenuController::class, 'removeBgImage'])->name('menu.remove.bg');
        Route::get('menu/intro/video/remove/{id}/{key}', [VideoWallMenuController::class, 'removeIntroVideo']);
        Route::get('media', [VideoWallMediaController::class, 'video_wall_video_index'])->name('media.index');
        Route::get('media/create', [VideoWallMediaController::class, 'video_wall_video_create'])->name('media.create');
        Route::post('media', [VideoWallMediaController::class, 'video_wall_video_store'])->name('media.store');
        Route::delete('media/{id}', [VideoWallMediaController::class, 'video_wall_video_delete'])->name('media.delete');
        Route::get('image/remove/{id}', [VideoWallMediaController::class, 'remove_image'])->name('image.remove.gallery');

        Route::get('gallery', [VideoWallGalleryController::class, 'index'])->name('gallery.index');
        Route::get('gallery/create', [VideoWallGalleryController::class, 'create'])->name('gallery.create');
        Route::post('gallery', [VideoWallGalleryController::class, 'store'])->name('gallery.store');
        Route::get('gallery/{id}/edit', [VideoWallGalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('gallery/{id}', [VideoWallGalleryController::class, 'update'])->name('gallery.update');
        Route::get('gallery/{id}', [VideoWallGalleryController::class, 'delete'])->name('gallery.delete');

        Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
    });
    //-------- /Video Wall Screen --------//

    //-------- Video Wall Screen --------//
    Route::prefix('map-screen')->name('map.')->group(function () {
        Route::resource('screens', \App\Http\Controllers\MapScreenController::class);
        Route::get('getscreenmainmenu/{screen_id}', [VideoWallScreenController::class, 'getscreenmainmenu'])->name('getscreenmainmenu');
        Route::get('getscreensidemenu/{screen_id}', [VideoWallScreenController::class, 'getscreensidemenu'])->name('getscreensidemenu');
        Route::resource('content', \App\Http\Controllers\MapContentController::class);
        Route::resource('menus', \App\Http\Controllers\MapMenuController::class);
        Route::get('menu/bg/remove/{id}', [VideoWallMenuController::class, 'removeBgImage'])->name('menu.remove.bg');
        Route::get('menu/intro/video/remove/{id}/{key}', [VideoWallMenuController::class, 'removeIntroVideo']);
        Route::get('media', [VideoWallMediaController::class, 'video_wall_video_index'])->name('media.index');
        Route::get('media/create', [VideoWallMediaController::class, 'video_wall_video_create'])->name('media.create');
        Route::post('media', [VideoWallMediaController::class, 'video_wall_video_store'])->name('media.store');
        Route::delete('media/{id}', [VideoWallMediaController::class, 'video_wall_video_delete'])->name('media.delete');
        Route::get('image/remove/{id}', [VideoWallMediaController::class, 'remove_image'])->name('image.remove.gallery');

        Route::get('gallery', [VideoWallGalleryController::class, 'index'])->name('gallery.index');
        Route::get('gallery/create', [VideoWallGalleryController::class, 'create'])->name('gallery.create');
        Route::post('gallery', [VideoWallGalleryController::class, 'store'])->name('gallery.store');
        Route::get('gallery/{id}/edit', [VideoWallGalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('gallery/{id}', [VideoWallGalleryController::class, 'update'])->name('gallery.update');
        Route::get('gallery/{id}', [VideoWallGalleryController::class, 'delete'])->name('gallery.delete');

        Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
    });
    //-------- /Video Wall Screen --------//

    /*
    //-- with rfid --//
        Route::prefix('with-rfid-screen')->name('withrfid.')->group(function () {
            Route::resource('screens', PortraitScreenController::class);

            Route::get('media', [MediaController::class, 'with_rfid_video_index'])->name('media.index');
            Route::get('media/create', [MediaController::class, 'with_rfid_video_create'])->name('media.create');
            Route::post('media', [MediaController::class, 'with_rfid_video_store'])->name('media.store');
            Route::delete('media/{id}', [MediaController::class, 'with_rfid_video_delete'])->name('media.delete');

            Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
        });
    //-- /with rfid --//
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('change_logo', [SettingController::class, 'change_logo'])->name('change_logo');
        Route::post('fonts', [SettingController::class, 'change_fonts'])->name('change_fonts');
        Route::get('remove/logo/{id}', [SettingController::class, 'destroy'])->name('remove.logo');
    });
    // Route::prefix('media')->name('media.')->controller(MediaController::class)->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('create', 'create')->name('create');
    //     // Route::get('withdraw_declined', 'withdraw_declined')->name('withdraw_declined');
    //     // Route::get('withdraw_unpaid', 'withdraw_unpaid')->name('withdraw_unpaid');
    //     // Route::get('withdraw_delete/{id}', 'withdraw_delete')->name('withdraw_delete');
    //     // Route::get('withdraw_approve/{id}', 'withdraw_approve')->name('withdraw_approve');
    //     // Route::post('withdraw_approve_multi', 'withdraw_approve_multi')->name('withdraw_approve_multi');
    //     // Route::get('withdraw_decline/{id}', 'withdraw_decline')->name('withdraw_decline');
    // });
});
//
////-- Media --//
//Route::get('media', [MediaController::class, 'without-rfid-screen_video_index'])->name('media.index');
//Route::get('media/create', [MediaController::class, 'without-rfid-screen_video_create'])->name('media.create');
//Route::post('media', [MediaController::class, 'without-rfid-screen_video_store'])->name('media.store');
//Route::delete('media/{id}', [MediaController::class, 'without-rfid-screen_video_delete'])->name('media.delete');
//Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('media.upload');
////-- /Media --//
