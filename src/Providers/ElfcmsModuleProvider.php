<?php

namespace Elfcms\Blog\Providers;

use Elfcms\Elfcms\Http\Middleware\AccountUser;
use Elfcms\Elfcms\Http\Middleware\AdminUser;
use Elfcms\Elfcms\Http\Middleware\CookieCheck;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
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
        /* $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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

        $startFile = __DIR__.'/../../start.json';
        $firstStart = false;
        if (file_exists($startFile)) {
            $json = File::get($startFile);
            $fileArray = json_decode($json,true);
            if ($fileArray['first_run']) {
                $firstStart = true;
            }
        }
        if ($firstStart) {
            Artisan::call('vendor:publish',['--provider'=>'Elfcms\Blog\Providers\ElfModuleProvider','--force'=>true]);
            Artisan::call('migrate');
            if (unlink($startFile)) {
                //
            }
            elseif (!empty($fileArray)) {
                file_put_contents($startFile,json_encode($fileArray));
            }
        }

        $router->middlewareGroup('admin', array(
            AdminUser::class
        ));

        $router->middlewareGroup('account', array(
            AccountUser::class
        ));

        $router->middlewareGroup('cookie', array(
            CookieCheck::class
        )); */
        $moduleDir = dirname(__DIR__);

        $locales = config('elfcms.elfcms.locales');

        $this->loadRoutesFrom($moduleDir.'/routes/web.php');
        $this->loadViewsFrom($moduleDir.'/resources/views', 'elfcms');
        $this->loadMigrationsFrom($moduleDir.'/database/migrations');

        $this->loadTranslationsFrom($moduleDir.'/resources/lang', 'blog');

        /* if (!empty($locales) && is_array($locales)) {
            foreach ($locales as $locale) {
                if (!empty($locale['code'])) {
                    $this->publishes([
                        $moduleDir.'/resources/lang/'.$locale['code'].'/validation.php' => resource_path('lang/'.$locale['code'].'/validation.php'),
                    ],'lang');
                }
            }
        } */

        $this->publishes([
            $moduleDir.'/resources/lang' => resource_path('lang/elfcms/blog'),
        ],'lang');

        $this->publishes([
            $moduleDir.'/config/blog.php' => config_path('elfcms/blog.php'),
        ],'config');

        $this->publishes([
            $moduleDir.'/resources/views/admin' => resource_path('views/elfcms/admin'),
        ],'admin');
        $this->publishes([
            $moduleDir.'/public/admin' => public_path('elfcms/admin/modules/blog/'),
        ], 'admin');

        /* $this->publishes([
            $moduleDir.'/resources/views/components' => resource_path('views/elfcms/components'),
        ],'components');

        $this->publishes([
            $moduleDir.'/resources/views/emails' => resource_path('views/elfcms/emails'),
        ],'emails'); */

    }
}
