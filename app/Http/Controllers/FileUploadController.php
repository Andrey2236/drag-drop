<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;

class FileUploadController extends Controller
{
    public function fileCreate()
    {
        $items = FileUpload::all();

        return view('fileupload', compact('items'));
    }

    public function fileStore(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('files'), $fileName);

        $fileUpload = new FileUpload();
        $fileUpload->filename = $fileName;
        $fileUpload->save();
        return response()->json(['success' => $fileName]);
    }

    public function fileDestroy(Request $request)
    {

        $filename = $request->get('filename');


        FileUpload::where('filename', $filename)->delete();
        $path = public_path() . '/files/' . $filename;

        if (file_exists($path)) {
            unlink($path);
        }

        return $filename;
    }


}
