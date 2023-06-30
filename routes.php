<?php

if (! Config::get('concreta.shorturl::disable_default_route')) {
    $builder = new \Concreta\ShortURL\Classes\Builder();
    $builder->routes();
}
