<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class DigitalOceanService {
    public function uploadImageToDO($image, $folder = '') {
        try {
            $filePath = Storage::disk('spaces')->putFile(env('DO_MAIN_PATH') . '/' . $folder, $image, 'public');
            return resultFunction("", true, env('DO_CDN') . $filePath);
        } catch (\Exception $e) {
            return resultFunction("Err code DOS-UI: catch " . $e->getMessage());
        }
    }
}