<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_setting')) {
    /**
     * Retrieve a site setting by key.
     * Use caching to avoid redundant database queries.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting(string $key, $default = null)
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        if (array_key_exists($key, $settings)) {
            $value = $settings[$key];
            
            // Handle boolean-like strings from form submissions
            if ($value === '1' || $value === 'true') return true;
            if ($value === '0' || $value === 'false') return false;
            
            return $value;
        }

        return $default;
    }
}
