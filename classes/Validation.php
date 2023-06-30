<?php

namespace Concreta\ShortURL\Classes;

use Config;
use Concreta\ShortURL\Exceptions\ValidationException as ShortValidationException;

class Validation
{
    /**
     * Validate all of the config related to the
     * library.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validateConfig(): bool
    {
        return $this->validateKeyLength()
               && $this->validateTrackingOptions()
               && $this->validateDefaultRouteOption()
               && $this->validateKeySalt()
               && $this->validateEnforceHttpsOption()
               && $this->validateForwardQueryParamsOption()
               && $this->validateDefaultUrl();
    }

    /**
     * Validate that the URL Length parameter specified
     * in the config is an integer that is above 0.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateKeyLength(): bool
    {
        $urlLength = Config::get('concreta.shorturl::key_length');

        if (! is_int($urlLength)) {
            throw new ShortValidationException('The config URL length is not a valid integer.');
        }

        if ($urlLength < 3) {
            throw new ShortValidationException('The config URL length must be 3 or above.');
        }

        return true;
    }


    protected function validatePrefix(): bool
    {
        $prefix = Config::get('concreta.shorturl::prefix');

        $prefix = trim($prefix, ' /');

        if ($prefix === null || $prefix === '') {
            throw new ShortValidationException('The config prefix cannot be null or empty.');
        }

        return true;
    }

    /**
     * Assert that the key salt provided in the config is
     * valid.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateKeySalt(): bool
    {
        $keySalt = Config::get('concreta.shorturl::key_salt');

        if (! is_string($keySalt)) {
            throw new ShortValidationException('The config key salt must be a string.');
        }

        if (! strlen($keySalt)) {
            throw new ShortValidationException('The config key salt must be at least 1 character long.');
        }

        return true;
    }

    /**
     * Validate that each of the tracking options are
     * booleans.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateTrackingOptions(): bool
    {
        $trackingOptions = Config::get('concreta.shorturl::tracking');

        if (! is_bool($trackingOptions['default_enabled'])) {
            throw new ShortValidationException('The default_enabled config variable must be a boolean.');
        }

        foreach ($trackingOptions['fields'] as $trackingOption => $value) {
            if (! is_bool($value)) {
                throw new ShortValidationException('The '.$trackingOption.' config variable must be a boolean.');
            }
        }

        return true;
    }

    /**
     * Validate that the disable_default_route option
     * is a boolean.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateDefaultRouteOption(): bool
    {
        if (! is_bool(Config::get('concreta.shorturl::disable_default_route'))) {
            throw new ShortValidationException('The disable_default_route config variable must be a boolean.');
        }

        return true;
    }

    /**
     * Validate that the enforce_https option is a boolean.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateEnforceHttpsOption(): bool
    {
        if (! is_bool(Config::get('concreta.shorturl::enforce_https'))) {
            throw new ShortValidationException('The enforce_https config variable must be a boolean.');
        }

        return true;
    }

    /**
     * Validate that the forward query params option is a boolean.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateForwardQueryParamsOption(): bool
    {
        if (! is_bool(Config::get('concreta.shorturl::forward_query_params'))) {
            throw new ShortValidationException('The forward_query_params config variable must be a boolean.');
        }

        return true;
    }

    /**
     * Validate that the default URL is a valid string or null.
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateDefaultUrl(): bool
    {
        $defaultUrl = Config::get('concreta.shorturl::default_url');
        $isValid = is_string($defaultUrl) || is_null($defaultUrl);

        if (! $isValid) {
            throw new ShortValidationException('The default_url config variable must be a string or null.');
        }

        return true;
    }
}
