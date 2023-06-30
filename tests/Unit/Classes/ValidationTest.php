<?php

namespace Concreta\ShortURL\Tests\Unit\Classes;

use Concreta\ShortURL\Classes\Validation;
use Concreta\ShortURL\Exceptions\ValidationException;
use Concreta\ShortURL\Tests\ShortPluginTestCase;
use Illuminate\Support\Facades\Config;

class ValidationTest extends ShortPluginTestCase
{
    /** @test */
    public function exception_is_thrown_if_the_key_length_is_not_an_integer()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The config URL length is not a valid integer.');

        Config::set('concreta.shorturl::key_length', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_key_length_is_below_3()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The config URL length must be 3 or above.');

        Config::set('concreta.shorturl::key_length', 2);

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_default_enabled_variable_is_not_a_boolean()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The default_enabled config variable must be a boolean.');

        Config::set('concreta.shorturl::tracking.default_enabled', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_any_of_the_tracking_options_are_not_null()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The ip_address config variable must be a boolean.');

        Config::set('concreta.shorturl::tracking.fields.ip_address', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_disable_default_route_option_is_not_a_boolean()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The disable_default_route config variable must be a boolean.');

        Config::set('concreta.shorturl::disable_default_route', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_key_salt_is_not_a_string()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The config key salt must be a string.');

        Config::set('concreta.shorturl::key_salt', true);

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_key_salt_is_less_than_one_character_long()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The config key salt must be at least 1 character long.');

        Config::set('concreta.shorturl::key_salt', '');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_enforce_https_variable_is_not_a_boolean()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The enforce_https config variable must be a boolean.');

        Config::set('concreta.shorturl::enforce_https', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_forward_query_params_variable_is_not_a_boolean()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The forward_query_params config variable must be a boolean.');

        Config::set('concreta.shorturl::forward_query_params', 'INVALID');

        $validation = new Validation();
        $validation->validateConfig();
    }

    /** @test */
    public function exception_is_thrown_if_the_default_url_is_not_a_string(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The default_url config variable must be a string or null.');

        Config::set('concreta.shorturl::default_url', true);

        $validation = new Validation();
        $validation->validateConfig();
    }
}
