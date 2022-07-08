<?php

use App\Models\Setting;
use Illuminate\Support\Arr;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException as InvalidArgumentExceptionAlias;

if (!function_exists('setting_set')) {
    function setting_set($key, $value = null)
    {
        $type = 'string';

        if (is_array($value)) {
            $type = 'json';
        } elseif (is_bool($value) || $value === 0) {
            $type = 'boolean';
        }

        Setting::updateOrCreate([
            'key' => $key
        ], [
            'value' => $value,
            'type'  => $type
        ]);

        cache()->set($key, $value);
    }
}

if (!function_exists('setting_get')) {
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentExceptionAlias
     * @throws JsonException
     */
    function setting_get($key, $cached = true)
    {
        if ($cached && cache()->has($key)) {
            return cache()->get($key);
        }

        $setting = Setting::where('key', $key)
            ->latest()
            ->first();

        if (is_null($setting)) {
            return null;
        }

        if ($setting->type === 'json' || $setting->type === 'boolean') {
            return json_decode($setting->value, true, 512, JSON_THROW_ON_ERROR);
        }

        cache()->set($key, $setting?->value);

        return $setting?->value;
    }
}
