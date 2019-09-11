<?php

namespace App\Providers;

use App\Topic;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('layout.sidebar', function ($view) {
            $topics = Topic::all();
            $view->with('topics', $topics);
        });

        /* 打印出sql到log里面
        \DB::listen(function ($query) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            if ($time > 1) { // 1ms
                logger('~$', compact('sql', 'bindings', 'time'));
            }
        });
        */
    }
}
