<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

trait FileHelper
{

    /**
     * @param UploadedFile $file
     * @param null $model
     * @return string
     */
    public function saveFileAndGetName(UploadedFile $file, $model = null)
    {
        return $file->store($this->getFolderName($model));
    }

    public function saveTempFileAndGetName($file)
    {
        try {
            $image = str_replace('data:image/jpeg;base64,', '', $file);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . str::random(30) . '.' . 'png';
            Storage::put('/Temps/' . $imageName, base64_decode($image));
            return 'Temps/' . $imageName;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveTempImageAndGetName(UploadedFile $file)
    {
        return $file->store("Temps");
    }

    public static function moveUploadedFile($file, $model)
    {
        return (new static)->moveFileFromTempAndGetName($file, $model);
    }

    public static function deleteUploadedFile($file)
    {
        return (new static)->deleteFile($file);
    }

    public function moveFileFromTempAndGetName($file, $model)
    {
        if ($file == 'faker') {
            return "faker.png";
        }
        if (!Storage::exists(storage_path($file)) && @ $name = explode('Temps/', $file)[1]) {
            $to = "{$this->getFolderName($model)}/{$name}";
            Storage::move($file, $to);
            return $to;
        }
        throw new \Exception('Error while moving file', 500);
    }

    public function rollBackTempFile($file, $model)
    {
        $file = str_replace('Temps', $this->getFolderName($model), $file);
        if (!Storage::exists(storage_path($file)) && @ $name = explode("{$this->getFolderName($model)}/", $file)[1]) {
            $to = "Temps/{$name}";
            Storage::move($file, $to);
            return $to;
        }
    }

    public function updateFileAndGetName(UploadedFile $file, $lastFile, $model = null)
    {
        return $this->deleteFile($lastFile)
            ->saveFileAndGetName($file, $model);
    }

    public function deleteFile($file)
    {
        if ($file && $file !== "" && Storage::exists($file))
            Storage::delete($file);
        return $this;
    }

    protected function getFolderName($model = null): Stringable
    {
        $class = $model ?: get_class();

        return Str::of($class)->afterLast('\\')->before('Controller')->kebab()
            ->slug('_')->plural();
    }

    public function getImagePath($key)
    {
        $file = $this->$key;
        if (empty($file) || $file == "faker.png") {
            return $this->getNoImagePath();
        }
        if (config('filesystems.default') == 's3') {
            return config('filesystems.disks.s3.url') . "/$file";
        }
        return asset("storage/$file");
    }

    public function getImageByName($name): ?string
    {
        if (!empty($name)) {
            if (config('filesystems.default') == 's3') {
                return config('filesystems.disks.s3.url') . "/$name";
            }
            return url("storage/$name");
        }
        return $this->getNoImagePath();
    }

    protected function getNoImagePath($file = null): string
    {
//        return "https://backend.mentorice.net/storage/".$file;

        if ($this instanceof Blog) {
            return 'https://cdn.dealspotr.com/ds-images/blog/payroll-software-smb5025.jpg';
        }

        return 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png';
    }

    public function uploadFileFromImage($url, $model)
    {
        try {
            $image = $this->hashImage($url, $model);
            if (!File::isDirectory($dir = storage_path('app/public') . '/' . $this->getFolderName($model))) {
                File::makeDirectory($dir);
            }

            Storage::put($image, file_get_contents($url));
            return $image;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    protected function hashImage($image, $model)
    {
        $path = pathinfo($image);
        $extension = @ $path['extension'] ?: 'png';
        return $this->getFolderName($model) . '/' . Str::random(40) . '.' . $extension;
    }

}
