<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class WebsiteSettingController extends Controller
{
    use FileHelper;

    public function index()
    {
        $setting = $this->getSettings();

        return view('admin.setting.website.index',
            compact('setting')
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(Request $request)
    {
        $files = ['headerLogo'];
        $this->updateFiles($files);

        foreach ($this->getKeys() as $key) {
            if ($key == 'headerLogo')
                continue;
            setting_set("website." . $key, @ $request->$key);
        }
    }

    private function getSettings(): Collection
    {
        $data = [];
        foreach ($this->getKeys() as $key) {
            $data[$key] = setting_get("website." . $key, false);
        }
        return collect($data);
    }

    /**
     * @return string[]
     */
    private function getKeys(): array
    {
        return [
            "headerLogo",
            "darKMode",
            "footerText",
            "facebook_link",
            "twitter_link",
            "linkedin_link",
            "instagram_link",
            "pinterest_link",
            "youtube_link",
            "currentTheme"
        ];
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws \Exception
     */
    private function updateFiles(array $files)
    {
        foreach ($files as $file) {
            if (request()->get($file) === "removed") {
                setting_set("website." . $file);

            } else if (request()->get($file) != null && request()->get($file) !== setting_get("website." . $file, false)) {
                $this->deleteFile(setting_get("website." . $file, false));
                setting_set("website." . $file,
                    $this->moveFileFromTempAndGetName(
                        request()->get($file),
                        "App\Models\Setting"
                    )
                );
            }
        }

    }
}

