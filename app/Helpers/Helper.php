<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function removePhysicalFile($path) {
        if(Storage::exists('public/' . $path)){
            Storage::delete('public/' . $path);
            /*
                Delete Multiple files this way
                Storage::delete(['upload/test.png', 'upload/test2.png']);
            */
        }
    }
}
