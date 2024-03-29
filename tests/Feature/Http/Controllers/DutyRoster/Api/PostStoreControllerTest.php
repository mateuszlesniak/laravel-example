<?php

namespace Tests\Feature\Http\Controllers\DutyRoster\Api;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostStoreControllerTest extends TestCase
{
    private const ENDPOINT = 'api/duty-rosters/store';

    public function testStore(): void
    {
        $file = UploadedFile::fake()
            ->createWithContent('file.html', $this->getDtrHtmlRoster());

        $response = $this->post(self::ENDPOINT, [
            'file' => $file,
        ]);

        $response->assertStatus(201);
    }

    public function testInvalidFileException(): void
    {
        $response = $this->post(self::ENDPOINT);

        $response->assertStatus(400);
    }
}
