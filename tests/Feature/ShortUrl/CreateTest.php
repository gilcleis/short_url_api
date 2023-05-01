<?php

namespace Tests\Feature\ShortUrl;

use App\Facades\Actions\CodeGenerator;
use App\Models\ShortUrl;
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

    /** @test */
    public function url_should_be_valid_url()
    {
        $this->postJson(
            route('short-url.store'),
            ['url' => 'not-valid-url']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'url' => __('validation.url', ['attribute' => 'url']),
            ]);
    }

    /** @test */
    public function it_should_return_the_existed_code_if_the_url_is_the_same()
    {
        ShortUrl::factory()->create([
            'url'       => 'https://www.google.com',
            'short_url' => config('app.url') . '/123456',
            'code'      => '123456',
        ]);

        $this->postJson(
            route('short-url.store'),
            ['url' => 'https://www.google.com']
        )->assertJson([
            'short_url' => config('app.url') . '/123456',
        ]);

        $this->assertDatabaseCount('short_urls', 1);
    }
}
