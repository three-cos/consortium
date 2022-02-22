<?php

use App\Http\Middleware\RequireApiToken;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Http\Resources\UserCollection;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/auth', function (Request $request) {
    return new Response([
        'token' => md5(time()), // временный вариант
    ], 200);
})->name('api.auth');

// Список Рубрик
Route::get('/topics', function (Request $request) {
    return new TopicCollection(Topic::paginate(config('api.items_per_page')));
})->name('api.topics');

// Информация о Рубрике
Route::get('/topic/{topic}', function (Request $request, Topic $topic) {
    return new TopicResource($topic);
})->name('api.topic');

Route::get('/topic/{id}/subscribe/{user:email}', function (Request $request, int $topic_id, User $user) {
    $topic = Topic::findOrFail($topic_id);

    $user->subscribeTo($topic);

    return new Response([
        'subscribed' => true
    ], 201);
})->name('api.topic.subscribe');

Route::get('/topic/{id}/unsubscribe/{user:email}', function (Request $request, int $topic_id, User $user) {
    $topic = Topic::findOrFail($topic_id);

    $user->unsubscribeFrom($topic);

    return new Response([
        'unsubscribed' => true
    ], 200);
})->name('api.topic.unsubscribe');

Route::get('/topics/unsubscribe/{user:email}', function (Request $request, User $user) {
    $user->unsubscribeFromAllTopics();

    return new Response([
        'unsubscribed' => true
    ], 200);
})->name('api.topic.unsubscribeAll');

Route::get('/users', function (Request $reuest) {
    return new UserCollection(User::paginate(config('api.items_per_page')));
})->name('api.users');

Route::get('/user/{user}/subscriptions', function (Request $request, User $user) {
    return new TopicCollection($user->subscriptions()->paginate(config('api.items_per_page')));
})->name('api.user.subscriptions')->middleware(RequireApiToken::class);

Route::get('/topic/{topic}/subscribers', function (Request $request, Topic $topic) {
    return new UserCollection($topic->subscribers()->paginate(config('api.items_per_page')));
})->name('api.topic.subscribers')->middleware(RequireApiToken::class);
