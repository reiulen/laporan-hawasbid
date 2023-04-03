<?php

use Carbon\Carbon;


if (!function_exists('set_active')) {
    function set_active($url, $output = 'active')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if (!function_exists('set_active_sub')) {
    function set_active_sub($url, $output = 'active-sub')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if (!function_exists('set_menu_open')) {
    function set_menu_open($url, $output = 'menu-open')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if(!function_exists('upload_file')){
    function upload_file($file, $path, $name, $width = null, $height = null){
        $file = $file;
        $filename = str_replace(' ', '', $name) . time(). rand(1,9999) .'.' . $file->getClientOriginalExtension();
        $destinationPath = 'uploads/file/' . $path;
        $file->move($destinationPath, $filename);
        return $destinationPath . '/' . $filename;
    }
}

if(!function_exists('nameRole')){
    function nameRole($role){
        switch($role) {
            case 1 :
                $role = 'Super Admin';
                break;
            case 2 :
                $role = 'Admin';
                break;
            case 3 :
                $role = 'User';
                break;
        }
        return $role;
    }
}

if(!function_exists('badgeRole')){
    function badgeRole($role){
        switch($role) {
            case 1 :
                $role = 'Super Admin';
                $badge = 'dark';
                break;
            case 2 :
                $role = 'Admin';
                $badge = 'primary';
                break;
            case 3 :
                $role = 'User';
                $badge = 'danger';
                break;
        }
        $component = "<span class='badge badge-$badge px-3 py-2'>$role</span>";
        return $component;
    }
}

if(!function_exists('penanggungJawabTipe')){
    function penanggungJawabTipe($value){
        $panitera = [
            'Panmud Permohonan',
            'Panmud Gugatan',
            'Panmud Hukum'
        ];
        $sekertaris = [
            'Kasubag PTIP',
            'Kasubag Umum & Keuangan',
            'Kasubag Kepegawaian'
        ];
        if(array_search($value, $panitera) !== false)
            return 1;
        else if(array_search($value, $sekertaris) !== false)
            return 2;
    }
}


if(!function_exists('triwulan')){
    function triwulan($value){
        switch($value) {
            case 1 :
                $value = 'I';
                break;
            case 2 :
                $value = 'II';
                break;
            case 3 :
                $value = 'III';
                break;
            case 4 :
                $value = 'IV';
                break;
        }
        return $value;
    }
}


if(!function_exists('dateMonthIndo')) {
    function dateMonthIndo($date)
    {
        return Carbon::parse($date)->format('d F Y');
    }
}
