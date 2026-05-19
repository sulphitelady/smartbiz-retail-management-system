<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        $currency = setting('currency', 'AED');

        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'AED' => 'AED ',
        ];

        return ($symbols[$currency] ?? '$') . number_format($amount, 2);
    }
}

if (!function_exists('userCan')) {
    function userCan($permission)
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // 🔐 ADMIN = FULL ACCESS
        if ($user->hasRole('admin')) {
            return true;
        }

        // 🔐 ROLE-BASED PERMISSIONS (simple logic)
        $permissions = [
            'manager' => ['view', 'create', 'edit', 'reports'],
            'staff'   => ['view', 'create'],
        ];

        if ($user->hasRole('manager')) {
            $perms = $permissions['manager'];
        } elseif ($user->hasRole('staff')) {
            $perms = $permissions['staff'];
        } else {
            $perms = [];
        }

        return in_array($permission, $perms);
    }
}