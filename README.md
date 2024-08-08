# Guest Microservice

## Описание

Этот микросервис предоставляет API для выполнения CRUD операций (создание, чтение, обновление, удаление) над сущностью "Гость". Микросервис разработан с использованием фреймворка Laravel и базы данных MySQL. Каждый гость имеет обязательные поля: имя, фамилия, телефон и email, при этом телефон и email уникальны. Также имеется атрибут страны, который, если не указан, определяется на основе номера телефона.

## Установка и запуск

### Требования

- Docker
- Docker Compose

### Шаги установки

1. Клонируйте репозиторий:
    ```bash
    git clone https://your-repo-url.git
    cd guest-microservice
    ```

2. Создайте файл `.env` и настройте параметры подключения к базе данных. Пример содержимого `.env`:
    ```dotenv
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:YOUR_KEY_HERE
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=YOUR_DATABASE_NAME_HERE
    DB_USERNAME=YOUR_NAME_HERE
    DB_PASSWORD=YOUR_PASSWORD_HERE

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    MEMCACHED_HOST=127.0.0.1

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=mailhog
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=null
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=mt1

    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    ```

3. Запустите контейнеры Docker:
    ```bash
    docker-compose up -d
    ```

4. Выполните миграции и сидирование базы данных:
    ```bash
    docker-compose exec app php artisan migrate --seed
    ```

## API

### Формат запросов и ответов

Все запросы и ответы в формате JSON. В ответах сервера присутствуют заголовки `X-Debug-Time` и `X-Debug-Memory`, указывающие время выполнения запроса и объем использованной памяти соответственно.

### Эндпоинты

#### Получение списка гостей

**GET** `/api/guests`

Ответ:
```json
 [
     {
         "id": 1,
         "first_name": "John",
         "last_name": "Doe",
         "email": "john.doe@example.com",
         "phone": "+79991234567",
         "country": "Russia",
         "created_at": "2023-12-01T12:34:56.000000Z",
         "updated_at": "2023-12-01T12:34:56.000000Z"
     }
 ]
```

#### Создание нового гостя

**POST** `/api/guests`

Тело запроса:
```json
[
    {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "phone": "+79991234567",
    "country": "Russia"
    }
]
```

Ответ:
```json
 [
     {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "phone": "+79991234567",
    "country": "Russia",
    "created_at": "2023-12-01T12:34:56.000000Z",
    "updated_at": "2023-12-01T12:34:56.000000Z"
    }
 ]
```

#### Получение информации о госте

**GET** `/api/guests/{id}`

Ответ:
```json
 [
     {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "phone": "+79991234567",
    "country": "Russia",
    "created_at": "2023-12-01T12:34:56.000000Z",
    "updated_at": "2023-12-01T12:34:56.000000Z"
    }
 ]
```

#### Обновление информации о госте

**PUT** `/api/guests/{id}`

Тело запроса:
```json
[
    {
    "first_name": "Jane",
    "last_name": "Doe",
    "email": "jane.doe@example.com",
    "phone": "+79991234567",
    "country": "Russia"
    }
]
```

Ответ:
```json
 [
     {
    "id": 1,
    "first_name": "Jane",
    "last_name": "Doe",
    "email": "jane.doe@example.com",
    "phone": "+79991234567",
    "country": "Russia",
    "created_at": "2023-12-01T12:34:56.000000Z",
    "updated_at": "2023-12-01T12:34:56.000000Z"
    }
 ]
```

**DELETE** `/api/guests/{id}`

Ответ:
```json
 [
     {
    "message": "Гость успешно удален"
    }
 ]
```
## Дополнительные сведения

### Структура проекта
* app/Services: Сервисы для бизнес-логики
* app/Repositories: Репозитории для работы с базой данных
* app/Http/Controllers: Контроллеры для обработки запросов

### Определение страны по номеру телефона

Для определения страны по номеру телефона используется библиотека libphonenumber. Если страна не указана при создании гостя, она определяется автоматически на основе номера телефона.

### Пример использования Postman
1. Создайте новый запрос в Postman.
2. Выберите тип запроса (GET, POST, PUT, DELETE).
3. Введите URL вашего API (например, http://localhost:8000/api/guests).
4. Для POST и PUT запросов выберите вкладку "Body" и добавьте JSON с данными.
5. Нажмите кнопку "Send".
6. Просмотрите ответ в области "Response".
