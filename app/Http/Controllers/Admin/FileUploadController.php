<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    use FileHelper;

    public function storeGallery(Request $request): string
    {
        return $this->saveTempImageAndGetName(
            $request->file('test')
        );
    }

    public function removeGallery()
    {
        $this->deleteFile(request()->get('file'));
    }

    public function fetchGallery(Request $request)
    {
        $name = $request->get('load');

        if (!Storage::exists($name)) {
            return response()->make('File no found.', 404);
        }

        $file = Storage::get($name);
        $type = Storage::mimeType($name);
        return response()->make($file, 200)->header("Content-Type", $type);
    }
}
