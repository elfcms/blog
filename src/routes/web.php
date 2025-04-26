<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

$adminPath = Config::get('elfcms.elfcms.admin_path') ?? 'admin';
$adminPath = trim($adminPath,'/');

Route::group(['middleware'=>['web', 'locales','cookie']],function() use ($adminPath) {

    Route::name('admin.')->middleware(['admin','access'])->group(function() use ($adminPath) {

        Route::get($adminPath . '/blog',[\Elfcms\Blog\Http\Controllers\AdminController::class,'blog'])
        ->name('blog');

        Route::prefix($adminPath . '/blog')->name('blog.')->group(function() use ($adminPath) {
            Route::post('/tags/addnotexist', [\Elfcms\Blog\Http\Controllers\Resources\BlogTagController::class,'addNotExist'])->name('tags.addnotexist');
            Route::resource('/tags', \Elfcms\Blog\Http\Controllers\Resources\BlogTagController::class)->names(['index' => 'tags']);
            Route::resource('/comments', \Elfcms\Blog\Http\Controllers\Resources\BlogCommentController::class)->names(['index' => 'comments']);
            Route::resource('/votes', \Elfcms\Blog\Http\Controllers\Resources\BlogVoteController::class)->names(['index' => 'votes']);
            Route::resource('/likes', \Elfcms\Blog\Http\Controllers\Resources\BlogLikeController::class)->names(['index' => 'likes']);


            Route::get('/nav/{blog?}/{category?}', [\Elfcms\Blog\Http\Controllers\BlogNavigator::class, 'index'])->name('nav');
            Route::resource('/blogs', \Elfcms\Blog\Http\Controllers\Resources\BlogController::class)->names(['index' => 'blogs']);
            Route::resource('/posts', \Elfcms\Blog\Http\Controllers\Resources\BlogPostController::class)->names(['index' => 'posts']);
            Route::resource('/categories', \Elfcms\Blog\Http\Controllers\Resources\BlogCategoryController::class)->names(['index' => 'categories']);

        });

        Route::name('ajax.')->group(function() {

            Route::name('blog.')->group(function() {
                Route::post('/elfcms/api/blog/{type}/lineorder', [Elfcms\Blog\Http\Controllers\Ajax\BlogController::class, 'lineOrder']);
            });

        });

    });
});
