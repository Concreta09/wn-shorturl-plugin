<?php

namespace Concreta\ShortURL\Providers;

use Config;
use Concreta\ShortURL\Classes\Builder;
use Concreta\ShortURL\Classes\Validation;
use Concreta\ShortURL\Exceptions\ValidationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ShortURLProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function boot(): void
    {
        if (Config::get('concreta.shorturl') && Config::get('concreta.shorturl::validate_config')) {
            (new Validation())->validateConfig();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('shorturlbuilder', function () {
            return new Builder();
        });
    }



    public function provides()
    {
        return ['shorturlbuilder'];
    }
}
