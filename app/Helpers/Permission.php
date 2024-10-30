<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class Permission {
    protected $permissions;
    protected $user;
    protected $role;
    
    public function __construct()
    {
        $this->permissions = collect(config('permission'));
        $this->user = Auth::user();
        $this->role = $this->user ? $this->user->role : null;
    }
    
    public function getPermission():Collection {
        return $this->permissions;
    }
    
    /**
     * Xử lý các route middeware
     * 
     */
    public function handleMiddleware($route, $type = 'name'):bool {
        if($this->user) {
            $role = $this->role;
            $listPermissionUser = $role->permissions;
        }
    
        $result = $this->permissions->filter(function ($item) use ($route) {
            return isset($item['list_route_name']) && is_array($item['list_route_name']) && in_array($route, $item['list_route_name']);
        });
        
        if(count($result) <= 0) return true; 
        
        if(!isset($this->user)) {
            return false;
        }
        
        if($role->permission_type == 'all') {
            return true;
        }
        
        $listPermissionCurrent = array_column($result->toArray(), 'code');
        
        if(empty(array_diff($listPermissionCurrent, $listPermissionUser))) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Hiển thị view dựa trên permissison
     * 
     */
    public function checkPermission($code):bool {
        $permission = $this->permissions->where('code', $code)->first();
        
        if(!$permission) return true;
        
        if($this->user) {
            $role = $this->role;
            $listPermissionUser = $role->permissions;
        } else {
            return false;
        }
        
        if($role->permission_type == 'all') {
            return true;
        }
        
        $permission_name = $permission['code'] ?? null;
        
        if(!in_array($permission_name, $listPermissionUser)) return false;
        
        return true;
    }
    
    
    /**
     * Check permission group
     * 
     */
    public function checkPermissionGroup($groupName):bool {
        $permissions = $this->permissions->filter(function ($item) use ($groupName) {
            $item['isPage'] = $item['isPage'] ?? false;
            return strpos($item['code'], $groupName) === 0 && $item['isPage'] === true;
        });
        
        if($this->user) {
            $role = $this->role;
            $listPermissionUser = $role->permissions;
        }
        
        if($role->permission_type == 'all') {
            return true;
        }
        
        if(count($permissions) <= 0) return false;
        
        foreach($listPermissionUser as $PermissionUser) {
            if(in_array($PermissionUser, array_column($permissions->toArray(), 'code'))) return true;
        }
        
        return false;
    }
}