<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Список рубрик на которые подписан пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscriptions()
    {
        return $this->belongsToMany(Topic::class, 'subscriptions');
    }

    /**
     * Подписать пользователя на рубрику
     *
     * @param  \App\Models\Topic $topic
     * @return void
     */
    public function subscribeTo(Topic $topic): void
    {
        Subscription::subscribe($this, $topic);
    }


    /**
     * Отписать пользователя от рубрики
     *
     * @param  \App\Models\Topic $topic
     * @return void
     */
    public function unsubscribeFrom(Topic $topic): void
    {
        Subscription::unsubscribe($this, $topic);
    }

    public function unsubscribeFromAllTopics(): void
    {
        Subscription::unsubscribeFromAll($this);
    }
}
