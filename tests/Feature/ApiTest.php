<?php

namespace Tests\Feature;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_api_returns_topics()
    {
        $topics = Topic::factory(10)->create();

        $response = $this->get('/api/topics');

        $response->assertStatus(200);

        $collection = $topics->map(function ($topic) {
            return $topic->only(['id', 'name']);
        });

        $expected = [
            'data' => $collection,
        ];

        $response->assertExactJson($expected);
    }
}
