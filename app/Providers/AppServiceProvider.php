<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\TesaurusFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register TesaurusFormatter helper
        $this->app->singleton('tesaurus-formatter', function () {
            return new TesaurusFormatter();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Make TesaurusFormatter available in views
        view()->composer('*', function ($view) {
            $view->with('formatter', new TesaurusFormatter());
        });
    }
}
