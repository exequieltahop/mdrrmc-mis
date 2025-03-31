<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivatePhotoHelper extends Controller
{
    public function get_responder_photo($file_path) {
        try {
            $request->validate([
                'path'
            ]);
        } catch (\Throwable $th) {
            return response();
        }
    }
}
