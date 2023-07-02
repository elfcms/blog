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

    'version' => '0.5',

    /*
    |--------------------------------------------------------------------------
    | Version of ELF CMS Basic
    |--------------------------------------------------------------------------
    |
    | Minimum version of ELF CMS Basic package
    |
    */

    'basic_package' => '1.1.0',

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
            "position" => 80,
            "submenu" => [
                [
                    "title" => "Blogs",
                    "lang_title" => "blog::elf.blogs",
                    "route" => "admin.blog.blogs"
                ],
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
