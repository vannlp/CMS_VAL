<?php

return [
    'user' => [
        'name' => "User",
        'code' => 'user',
        'type' => 'group',
        'isUse' => true,
        'auth' => true,
    ],
    
    'user.index' => [
        'name' => "Users list",
        'code' => 'user.index',
        'parent' => 'user',
        'type' => 'permission',
        'isUse' => true,
        'auth' => true,
        'isPage' => true,
        'list_route_name' => [
            'admin.user.index',
            'admin.user.datatable'
        ]
    ],
       
    'user.create' => [
        'name' => "Users create",
        'code' => 'user.create',
        'parent' => 'user',
        'type' => 'permission',
        'isUse' => true,
        'auth' => true,
        'list_route_name' => [
            'admin.user.create'
        ]
    ],
    
    'permission' => [
        'name' => "Permission",
        'code' => 'permission',
        'type' => 'group',
        'isUse' => true,
        'auth' => true,
    ],
    
    'permission.role.create' => [
        'name' => "Role create",
        'code' => 'permission.role.create',
        'type' => 'permission',
        'isUse' => true,
        'list_route_name' => []
    ],
    
    'permission.index' => [
        'name' => "Permission list",
        'code' => 'permission.index',
        'type' => 'permission',
        'isUse' => true,
        'list_route_name' => [
            'admin.permission.getPermissions'
        ]
    ],
];