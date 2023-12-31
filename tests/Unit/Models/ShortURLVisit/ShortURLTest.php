<?php

namespace Concreta\ShortURL\Tests\Unit\Models\ShortURLVisit;

use Concreta\ShortURL\Models\ShortURL;
use Concreta\ShortURL\Models\ShortURLVisit;
use Concreta\ShortURL\Tests\ShortPluginTestCase;

class ShortURLTest extends ShortPluginTestCase
{

    /** @test */
    public function short_url_can_be_fetched_from_visit(): void
    {
        $shortURL = ShortURL::create([
            'destination_url'   => 'https://example.com',
            'default_short_url' => 'https://domain.com/12345',
            'url_key'           => '12345',
            'single_use'        => true,
            'track_visits'      => true,
        ]);

        /** @var ShortURLVisit $visit */
        $visit = ShortURLVisit::create(['short_url_id' => $shortURL->id, 'visited_at' => now()]);

        $this->assertTrue($visit->shortURL->is($shortURL));
    }
}
