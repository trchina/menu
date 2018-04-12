<?php

namespace Keling\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true; // 延迟加载服务

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/menu.php' => config_path('menu.php'), // 发布配置文件到 laravel 的config 下
        ]);
        // 发布迁移文件
        $this->publishes([
            __DIR__.'/database/seeds/MenusTableSeeder.php' => database_path('seeds/MenusTableSeeder.php'),
        ]);
        // 迁移文件
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('menu', function ($app) {
            return new Packagetest($app['session'], $app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['menu'];
    }
}
