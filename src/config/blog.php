<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | Version of package
    |
    */

    'version' => '0.1',

    /*
    |--------------------------------------------------------------------------
    | Version of ELF CMS Basic
    |--------------------------------------------------------------------------
    |
    | Minimum version of ELF CMS Basic package
    |
    */

    'basic_package' => '0.6',

    /*
    |--------------------------------------------------------------------------
    | Menu data
    |--------------------------------------------------------------------------
    |
    | Menu data of this package for admin panel
    |
    */

    "menu" => [
        [
            "title" => "Blog",
            "lang_title" => "blog::elf.blog",
            "route" => "admin.blog.posts",
            "parent_route" => "admin.blog",
            "icon" => "/vendor/elfcms/blog/admin/images/icons/blog.png",
            "submenu" => [
                [
                    "title" => "Categories",
                    "lang_title" => "blog::elf.users",
                    "route" => "admin.users"
                ],
                [
                    "title" => "Posts",
                    "lang_title" => "blog::elf.roles",
                    "route" => "admin.users.roles"
                ],
            ]
        ],
    ],
];
