<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
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

        $response = $this->get(route('api.topics'));

        $response->assertStatus(200);

        $collection = $topics->map(function ($topic) {
            return $topic->only(['id', 'name']);
        });

        $expected = [
            'data' => $collection,
        ];

        $response->assertExactJson($expected);
    }

    /**
     * @return void
     */
    public function test_user_can_subscribe_on_topic()
    {
        $topic = Topic::factory()->create();
        $user = User::factory()->create();

        $this->get(route('api.topic.subscribe', [$topic->id, $user->email]));

        $this->assertDatabaseCount('subscriptions', 1);
    }

    /**
     * @return void
     */
    public function test_user_can_unsubscribe_from_topic()
    {
        [$topic_1, $topic_2] = Topic::factory(2)->create();
        $user = User::factory()->create();

        $this->get(route('api.topic.subscribe', [$topic_1->id, $user->email]));
        $this->get(route('api.topic.subscribe', [$topic_2->id, $user->email]));

        $this->get(route('api.topic.unsubscribe', [$topic_1->id, $user->email]));
        $this->assertDatabaseCount('subscriptions', 1);

        $this->get(route('api.topic.unsubscribe', [$topic_2->id, $user->email]));
        $this->assertDatabaseCount('subscriptions', 0);
    }

    /**
     * @return void
     */
    public function test_topic_can_get_all_subscribers()
    {
        $topic = Topic::factory(1)->create()->first();
        [$user_1, $user_2] = User::factory(2)->create();

        $user_1->subscribeTo($topic);
        $user_2->subscribeTo($topic);

        $response = $this->get(route('api.topic.subscribers', [$topic]));

        $response->assertJsonCount(2, 'data');
    }

    /**
     * @return void
     */
    public function test_user_can_get_all_subscriptions()
    {
        [$topic_1, $topic_2] = Topic::factory(2)->create();
        $user = User::factory()->create()->first();

        $user->subscribeTo($topic_1);
        $user->subscribeTo($topic_2);

        $response = $this->get(route('api.user.subscriptions', [$user]));

        $response->assertJsonCount(2, 'data');
    }
}
