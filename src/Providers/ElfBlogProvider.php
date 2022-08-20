<?php

namespace Elfcms\Blog\Providers;

use Elfcms\Basic\Http\Middleware\AccountUser;
use Elfcms\Basic\Http\Middleware\AdminUser;
use Elfcms\Basic\Http\Middleware\CookieCheck;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ElfBlogProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->register(EventServiceProvider::class);
        /* $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        ); */
        /* require_once __DIR__ . '/../Elf/UrlParams.php';
        require_once __DIR__ . '/../Elf/FormSaver.php';
        require_once __DIR__ . '/../Elf/Helpers.php'; */
        /* if (File::exists(__DIR__ . '/../Elf/UrlParams.php')) {
            require_once __DIR__ . '/../Elf/UrlParams.php';
        }
        if (File::exists(__DIR__ . '/../Elf/FormSaver.php')) {
            require_once __DIR__ . '/../Elf/FormSaver.php';
        }
        if (File::exists(__DIR__ . '/../Elf/Helpers.php')) {
            require_once __DIR__ . '/../Elf/Helpers.php';
        } */
        /* $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('UrlParams','Elfcms\Blog\Elf\UrlParams');
        $loader->alias('FormSaver','Elfcms\Blog\Elf\FormSaver');
        $loader->alias('Helpers','Elfcms\Blog\Elf\Helpers'); */

        //$router = $this->app['router'];
        //$router->pushMiddlewareToGroup('web', AdminUser::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blog');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'blog');

        //$this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'blog');

        $this->publishes([
            __DIR__.'/../config/blog.php' => config_path('elfcms/blog.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/elfcms/blog'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/elfcms/blog'),
        ]);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/elfcms/blog'),
        ], 'public');

        $router->middlewareGroup('admin', array(
            AdminUser::class
        ));

        $router->middlewareGroup('account', array(
            AccountUser::class
        ));

        $router->middlewareGroup('cookie', array(
            CookieCheck::class
        ));
    }
}
