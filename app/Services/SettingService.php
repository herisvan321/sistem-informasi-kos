<?php

namespace App\Services;

use App\Models\Setting;

class SettingService extends BaseService
{
    public function __construct(Setting $setting)
    {
        parent::__construct($setting);
    }

    public function updateByKey(string $key, $value): bool
    {
        return (bool) Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getByKey(string $key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
