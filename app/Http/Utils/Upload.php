<?php

namespace App\Http\Utils;

class Upload
{
    static public function store($folder, $file)
    {

        // dd($request->file()); die;
        $avatar = time() . '-' . \Illuminate\Support\Str::random(34) . '.' . $file->getClientOriginalExtension();

        // $canvas = Image::canvas(150, 150);
        //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY
        //DENGAN MEMPERTAHANKAN RATIO
        if (!is_dir(storage_path($folder))) {
            mkdir(storage_path($folder), 0755);
        }
        // dd($resizeImage);die;
        //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
        // $canvas->insert($resizeImage, 'center');

        //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)

        $file->move(storage_path($folder), $avatar);
        // $request->file('files')->move(storage_path($folder), $avatar);
        $path = "/upload-file/" . $folder . "/" . $avatar;
        return $path;
    }
}

?>
