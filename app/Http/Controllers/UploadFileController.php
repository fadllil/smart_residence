<?php

namespace App\Http\Controllers;

use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadFileController extends Controller
{
    public function store(Request $request, $folder){
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required'
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $file = $request->file;
        $avatar = time() . '-' . \Illuminate\Support\Str::random(34) . '.' . $file->getClientOriginalExtension();

        if (!is_dir(storage_path($folder))) {
            mkdir(storage_path($folder), 0755);
        }

        $file->move(storage_path($folder), $avatar);
        $path = "/upload-file/" . $folder . "/" . $avatar;
        return Response::success('File gambar', $path);
    }

    public function getFile($folder, $nama)
    {
        $avatar_path = storage_path($folder) . '/' . $nama;
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/*');
        }
        return 'Gambar tidak ditemukan';
    }
}
