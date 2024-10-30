<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;


class Menu {
    
    public static function addVerticalMenu(array $menu) {
        // Share all menuData to all the views
        
        $menuData = app()->make('view')->shared('menuData');
        $menuData[0]->menu[] = Helpers::arrayToObject($menu);
        
        app()->make('view')->share('menuData', $menuData);
    }
    
    public static function addMenu(string $slug ,array $menu) {
       // Share all menuData to all the views
        
       $menuData = app()->make('view')->shared('menuData');
       foreach ($menuData[0]->menu as $menu_f) {
            if($menu_f->slug == $slug) {
                $menu_f->submenu[] = Helpers::arrayToObject($menu);
            }
       }
       
    //    dd($menuData[0]);
       
       app()->make('view')->share('menuData', $menuData);
    }
}