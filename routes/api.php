<?php

use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
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
});

// Информация о Рубрике
Route::get('/topic/{id}', function (Request $request, int $id) {
    return new TopicResource(Topic::findOrFail($id));
});
