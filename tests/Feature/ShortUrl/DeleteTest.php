<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    
    /** @test */
    public function it_can_delete_a_short_url()
    {
        $shortUrl = ShortUrl::factory()->create();

        $this->deleteJson(route('short-url.destroy', $shortUrl->code))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('short_urls', [
            'id' => $shortUrl->id,
        ]);
    }
}
