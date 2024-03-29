<?php

namespace Tests\Feature\Http\Controllers\DutyRoster\Api;

use Tests\TestCase;

class GetEventControllerTest extends TestCase
{
    public function testGetEvent(): void
    {
        $response = $this->get('api/duty-rosters/event');

        $response->assertStatus(200);
    }

}
