<?php

namespace Elfcms\Blog\Providers;

use Elfcms\Elfcms\Http\Middleware\AccountUser;
use Elfcms\Elfcms\Http\Middleware\AdminUser;
use Elfcms\Elfcms\Http\Middleware\CookieCheck;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ElfcmsModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $moduleDir = dirname(__DIR__);

        $locales = config('elfcms.elfcms.locales');

        $this->loadRoutesFrom($moduleDir . '/routes/web.php');
        $this->loadViewsFrom($moduleDir . '/resources/views', 'elfcms');
        $this->loadMigrationsFrom($moduleDir . '/database/migrations');

        $this->loadTranslationsFrom($moduleDir . '/resources/lang', 'blog');

        $this->publishes([
            $moduleDir . '/resources/lang' => resource_path('lang/elfcms/blog'),
        ], 'lang');

        $this->publishes([
            $moduleDir . '/config/blog.php' => config_path('elfcms/blog.php'),
        ], 'config');

        $this->publishes([
            $moduleDir . '/resources/views/admin' => resource_path('views/elfcms/admin'),
        ], 'admin');

        $this->publishes([
            $moduleDir . '/public/admin' => public_path('elfcms/admin/modules/blog/'),
        ], 'admin');

        Blade::component('blog-posts', \Elfcms\Blog\View\Components\Posts::class);
    }
}
