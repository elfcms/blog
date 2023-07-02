<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

$adminPath = Config::get('elfcms.basic.admin_path') ?? '/admin';

Route::group(['middleware'=>['web','cookie','start']],function() use ($adminPath) {

    Route::name('admin.')->middleware('admin')->group(function() use ($adminPath) {

        Route::get($adminPath . '/blog',[\Elfcms\Blog\Http\Controllers\AdminController::class,'blog'])
        ->name('blog');

        Route::name('blog.')->group(function() use ($adminPath) {
            Route::resource($adminPath . '/blog/blogs', \Elfcms\Blog\Http\Controllers\Resources\BlogController::class)->names(['index' => 'blogs']);
            Route::resource($adminPath . '/blog/categories', \Elfcms\Blog\Http\Controllers\Resources\BlogCategoryController::class)->names(['index' => 'categories']);
            Route::resource($adminPath . '/blog/posts', \Elfcms\Blog\Http\Controllers\Resources\BlogPostController::class)->names(['index' => 'posts']);
            Route::post($adminPath . '/blog/tags/addnotexist', [\Elfcms\Blog\Http\Controllers\Resources\BlogTagController::class,'addNotExist'])->name('tags.addnotexist');
            Route::resource($adminPath . '/blog/tags', \Elfcms\Blog\Http\Controllers\Resources\BlogTagController::class)->names(['index' => 'tags']);
            Route::resource($adminPath . '/blog/comments', \Elfcms\Blog\Http\Controllers\Resources\BlogCommentController::class)->names(['index' => 'comments']);
            Route::resource($adminPath . '/blog/votes', \Elfcms\Blog\Http\Controllers\Resources\BlogVoteController::class)->names(['index' => 'votes']);
            Route::resource($adminPath . '/blog/likes', \Elfcms\Blog\Http\Controllers\Resources\BlogLikeController::class)->names(['index' => 'likes']);
        });
    });
});
