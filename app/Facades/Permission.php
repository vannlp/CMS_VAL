<?php

namespace App\Facades;

use App\Helpers\Permission as HelpersPermission;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

/**
 * @method static \App\Helpers\Permission \Illuminate\Support\Collection getPermission()
 * @method static \App\Helpers\Permission handleMiddleware(string $route, string $type = 'name')
 * @method static \App\Helpers\Permission checkPermission(string $code)
 * @method static \App\Helpers\Permission checkPermissionGroup(string $groupName)
 *
 * @see \App\Helpers\Permission
 */
class Permission extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HelpersPermission::class;
    }
}