<?php

use App\Helpers\JsonRes;
use App\Helpers\Permission;

if(!function_exists('jsonRes')) {
    function jsonRes() {
        return app()->make(JsonRes::class);
    }
    
}

if(!function_exists('permission')) {
    function permission() {
        return app()->make(Permission::class);
    }
    
}