<?php

namespace Concreta\ShortURL\Tests\Unit\Models\ShortURLVisit;

use Concreta\ShortURL\Models\ShortURL;
use Concreta\ShortURL\Models\ShortURLVisit;
use Concreta\ShortURL\Tests\ShortPluginTestCase;

class ShortURLVisitFactoryTest extends ShortPluginTestCase
{
    /** @test */
    public function test_that_short_url_visit_model_factory_works_fine(): void
    {
        $shortURL = ShortURL::factory()->create();

        $shortURLVisit = ShortURLVisit::factory()->for($shortURL)->create();

        $this->assertDatabaseCount('concreta_shorturl_short_url_visits', 1)
            ->assertDatabaseCount('concreta_shorturl_shorturls', 1)
            ->assertModelExists($shortURLVisit)
            ->assertModelExists($shortURL);

        $this->assertTrue($shortURLVisit->shortURL->is($shortURL));
    }
}
