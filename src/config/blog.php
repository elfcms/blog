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

    'version' => '1.0.2',
    'developer' => 'Maxim Klassen',
    'license' => 'MIT',
    'author' => 'Maxim Klassen',
    'title' => 'Blog',
    'description' => '',
    'url' => '',
    'github' => 'https://github.com/elfcms/blog',
    'release_status' => 'stable',
    'release_date' => '2025',

    /*
    |--------------------------------------------------------------------------
    | Version of ELF CMS Basic
    |--------------------------------------------------------------------------
    |
    | Minimum version of ELF CMS Basic package
    |
    */

    'basic_package' => '3.0',

    /*
    |--------------------------------------------------------------------------
    | Files
    |--------------------------------------------------------------------------
    |
    | File upload options
    |
    */

    "files" => [
        "max_size" => [
            "preview" => 768,
            "image" => 1024
        ]
    ],

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
            "lang_title" => "blog::default.blog",
            "route" => "admin.blog.nav",
            "parent_route" => "admin.blog",
            "icon" => "/elfcms/admin/modules/blog/images/icons/blog.svg",
            "position" => 400,
            "color" => "#2abc8f",
            "second_color" => "#30a8ab",
            "submenu" => [
                [
                    "title" => "Navigation",
                    "lang_title" => "blog::default.navigation",
                    "route" => "admin.blog.nav"
                ],
                [
                    "title" => "Tags",
                    "lang_title" => "blog::default.tags",
                    "route" => "admin.blog.tags"
                ],
                [
                    "title" => "Comments",
                    "lang_title" => "blog::default.comments",
                    "route" => "admin.blog.comments"
                ],
                [
                    "title" => "Votes",
                    "lang_title" => "blog::default.votes",
                    "route" => "admin.blog.votes"
                ],
                [
                    "title" => "Likes",
                    "lang_title" => "blog::default.likes",
                    "route" => "admin.blog.likes"
                ],
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Search settings
    |--------------------------------------------------------------------------
    |
    | Settings for search module
    |
    */

    "search" => [
        "tables" => [
            [
                "model" => "Elfcms\Blog\Models\BlogPost",
                "name" => "blog_posts",
                "fields" => [
                    "name" => "blog::default.search_post_name",
                    "description" => "blog::default.search_post_description",
                    "text" => "blog::default.search_post_text"
                ],
                "result" => "slug",
                "description" => "blog::default.search_post",
            ],
            [
                "model" => "Elfcms\Blog\Models\BlogCategory",
                "name" => "blog_categories",
                "fields" => [
                    "name" => "blog::default.search_category_name",
                    "description" => "blog::default.search_category_description"
                ],
                "result" => "slug",
                "description" => "blog::default.search_category",
            ],
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Access control
    |--------------------------------------------------------------------------
    |
    | Define access rules for admin panel pages.
    |
    */

    "access_routes" => [
        [
            "title" => "Blog",
            "lang_title" => "blog::default.blog",
            "route" => "admin.blog",
            "actions" => ["read", "write"],
        ],
    ],

    "pages" => [
        'name' => 'Blog',
        'class' => \Elfcms\Blog\Models\Blog::class ?? null,
        'options_view' => 'elfcms::admin.pages.modules.blog-options',
    ],
];
