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
            "route" => "admin.blog",
            "parent_route" => "admin.blog",
            "icon" => "/vendor/elfcms/blog/admin/images/icons/blog.png",
            "submenu" => [
                [
                    "title" => "Categories",
                    "lang_title" => "blog::elf.categories",
                    "route" => "admin.blog.categories"
                ],
                [
                    "title" => "Posts",
                    "lang_title" => "blog::elf.posts",
                    "route" => "admin.blog.posts"
                ],
                [
                    "title" => "Tags",
                    "lang_title" => "blog::elf.tags",
                    "route" => "admin.blog.tags"
                ],
                [
                    "title" => "Comments",
                    "lang_title" => "blog::elf.comments",
                    "route" => "admin.blog.comments"
                ],
                [
                    "title" => "Votes",
                    "lang_title" => "blog::elf.votes",
                    "route" => "admin.blog.votes"
                ],
                [
                    "title" => "Likes",
                    "lang_title" => "blog::elf.likes",
                    "route" => "admin.blog.likes"
                ],
            ]
        ],
    ],
];
