<?php
return [
  "verticalMenu" => [
    "menu" => [
      [
        "name" => "Dashboards",
        "icon" => "menu-icon tf-icons ri-home-smile-line",
        "slug" => "dashboard",
        'permission_group' => '',
        "badge" => [
          // "danger",
          // "5"
        ],
        "submenu" => [
          [
            "url" => "app/ecommerce/dashboard",
            "name" => "eCommerce",
            "slug" => "app-ecommerce-dashboard"
          ],
        ]
      ],
      [
        "name" => "Users",
        "icon" => "menu-icon tf-icons ri-user-line",
        "slug" => "users",
        'permission_group' => 'user',
        "badge" => [
          // "danger",
          // "5"
        ],
        "submenu" => [
          [
            "url" => "/admin/user",
            "name" => "Danh sách",
            "slug" => "user-list",
            "permission_name" => 'user.index'
          ],
        ]
      ],
      
      [
        "name" => "Settings",
        "icon" => "menu-icon tf-icons ri-settings-2-line",
        "slug" => "settings",
        'permission_group' => 'settings',
        "badge" => [
          // "danger",
          // "5"
        ],
        "submenu" => [
          [
            "url" => "/admin/settings/permission",
            "name" => "Quyền",
            "slug" => "settings-permission",
            "permission_name" => 'settings.permission'
          ],
        ]
      ],
    ]
  ]  
];