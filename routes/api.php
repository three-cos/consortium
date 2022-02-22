<?php

use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
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

// Список Рубрик
Route::get('/topics', function (Request $request) {
    return new TopicCollection(Topic::all());
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
});
