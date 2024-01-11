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

    'version' => '0.5.1',

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
            "lang_title" => "blog::default.blog",
            "route" => "admin.blog",
            "parent_route" => "admin.blog",
            "icon" => "/vendor/elfcms/blog/admin/images/icons/blog.png",
            "position" => 200,
            "submenu" => [
                [
                    "title" => "Blogs",
                    "lang_title" => "blog::default.blogs",
                    "route" => "admin.blog.blogs"
                ],
                [
                    "title" => "Categories",
                    "lang_title" => "blog::default.categories",
                    "route" => "admin.blog.categories"
                ],
                [
                    "title" => "Posts",
                    "lang_title" => "blog::default.posts",
                    "route" => "admin.blog.posts"
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
];
