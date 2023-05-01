<?php

namespace Tests\Feature\ShortUrl;

use App\Facades\Actions\CodeGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertJson;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    /** @test */
    public function it_should_be_able_to_create_short_url()
    {
        $randomCode = Str::random(5);

        CodeGenerator::shouldReceive('run')
            ->once()
            ->andReturn($randomCode);

        $this->postJson(
            route('short-url.store'),
            ['url' => 'https://www.google.com']
        )->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'short_url' => config('app.url') . '/' . $randomCode,
            ]);

        $this->assertDatabaseHas('short_urls', [
            'url'       => 'https://www.google.com',
            'short_url' => config('app.url') . '/' . $randomCode,
            'code'      => $randomCode,
        ]);
    }
}
