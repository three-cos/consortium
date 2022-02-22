## Тестовое задание для Консорциум кодекс

### Запуск
```php
/vendor/bin/sail up
/vendor/bin/sail artisan migrate --seed
```

### API
```php
// Получение токена
localhost/api/auth

// Список всех Рубрик
localhost/api/topics

// Информация о Рубрике
localhost/api/topic/{topic_id}

// Подписка Пользователя на Рубрику
localhost/api/topic/{topic_id}/subscribe/{user_email}

// Отписка Пользователя от Рубрики
localhost/api/topic/{topic_id}/unsubscribe/{user_email}

// Описка Пользователя от всех Рубрик
localhost/api/topics/unsubscribe/{user_email}

// Список Пользователей
localhost/api/users

// Список Подписок Пользователя
// Требует Токен
localhost/api/user/{user}/subscriptions

// Список Подписчиков Рубрики
// Требует Токен
localhost/api/topic/{topic}/subscribers
```

#### Тестирование
```php
/vendor/bin/sail test
```