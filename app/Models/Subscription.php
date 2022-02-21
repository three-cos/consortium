<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Подписка
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * Рубрика
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Подписка пользователя на рубрику
     *
     * @param  \App\Models\User $user
     * @param  \App\Modles\Topic $topic
     * @return void
     */
    public static function subscribe(User $user, Topic $topic): void
    {
        $user->topics()->attach($topic);
    }

    /**
     * Отписка пользователя от рубрики
     *
     * @param  \App\Models\User $user
     * @param  \App\Modles\Topic $topic
     * @return void
     */
    public static function unsubscribe(User $user, Topic $topic): void
    {
        $user->topics()->detach($topic);
    }
}
