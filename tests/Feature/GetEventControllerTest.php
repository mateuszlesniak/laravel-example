<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetEventControllerTest extends TestCase
{
    public function testGetEvent(): void
    {
        $response = $this->get('api/duty-rosters/event');

        $response->assertStatus(200);
    }

}
