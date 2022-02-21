<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_user_can_subscribe_to_topic()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $user->subscribeTo($topic);

        $this->assertDatabaseHas('subscriptions', ['user_id' => 1, 'topic_id' => 1]);
    }

    /**
     * @return void
     */
    public function test_user_can_unsubscribe_from_topic()
    {
        $user = User::factory()->create();
        $topic_1 = Topic::factory()->create();
        $topic_2 = Topic::factory()->create();

        $user->subscribeTo($topic_1);
        $user->subscribeTo($topic_2);

        $this->assertDatabaseCount('subscriptions', 2);

        $user->unsubscribeFrom($topic_1);

        $this->assertDatabaseCount('subscriptions', 1);
    }


    /**
     * @return void
     */
    public function test_user_and_topic_have_access_through_subscription()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $user->subscribeTo($topic);

        $this->assertEquals($user->id, $topic->subscribers->first()->id);
        $this->assertEquals($topic->id, $user->topics->first()->id);
    }
}
