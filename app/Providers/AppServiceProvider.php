<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // The public domain sits behind an HTTPS proxy that forwards plain HTTP,
        // so asset()/route() would emit http:// links the browser blocks as mixed content.
        $https_hosts = array_filter(array_map('trim', explode(',', config('app.force_https_hosts', ''))));
        if (!$this->app->runningInConsole() && in_array(request()->getHost(), $https_hosts)) {
            URL::forceScheme('https');
        }
    }
}
