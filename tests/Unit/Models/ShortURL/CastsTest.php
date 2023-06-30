<?php

declare(strict_types=1);

namespace Concreta\ShortURL\Tests\Unit\Models\ShortURL;

use Concreta\ShortURL\Classes\KeyGenerator;
use Concreta\ShortURL\Models\ShortURL;
use Concreta\ShortURL\Tests\ShortPluginTestCase;
use Carbon\Carbon;
// use Faker\Generator as Faker;

final class CastsTest extends ShortPluginTestCase
{
    // public $faker;

    /** @test */
    public function carbon_date_objects_are_returned_by_factory(): void
    {
        $shortUrl = ShortURL::factory()
            ->create([
                'activated_at' => now(),
                'deactivated_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $shortUrl->refresh();

        $this->assertInstanceOf(Carbon::class, $shortUrl->activated_at);
        $this->assertInstanceOf(Carbon::class, $shortUrl->deactivated_at);
        $this->assertInstanceOf(Carbon::class, $shortUrl->created_at);
        $this->assertInstanceOf(Carbon::class, $shortUrl->updated_at);
    }

    // /** @test */
    // public function carbon_date_objects_are_returned(): void
    // {
    //
    //     $this->faker = new Faker();
    //
    //     // dd(get_class_vars($this->faker));
    //
    //     $urlKey = (new KeyGenerator())->generateRandom();
    //
    //     $shortUrl = ShortURL::create([
    //             'destination_url' => 'https://domain.tld',
    //             'default_short_url' => url($urlKey),
    //             'url_key' => $urlKey,
    //             'single_use' => true,
    //             'forward_query_params' => true,
    //             'track_visits' => true,
    //             'redirect_status_code' => 301,
    //             'track_ip_address' => true,
    //             'track_operating_system' => true,
    //             'track_operating_system_version' => true,
    //             'track_browser' => true,
    //             'track_browser_version' => true,
    //             'track_referer_url' => true,
    //             'track_device_type' => true,
    //
    //             'activated_at' => now(),
    //             'deactivated_at' => now(),
    //             'deleted_at' => now(),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //
    //     $shortUrl->refresh();
    //
    //     $this->assertInstanceOf(Carbon::class, $shortUrl->activated_at);
    //     $this->assertInstanceOf(Carbon::class, $shortUrl->deactivated_at);
    //     $this->assertInstanceOf(Carbon::class, $shortUrl->created_at);
    //     $this->assertInstanceOf(Carbon::class, $shortUrl->updated_at);
    // }
}
