
## DESCRIPTION
Описание тестового задания https://docs.google.com/document/d/e/2PACX-1vTpVMaQ9WmK6NKmoYJEwb2vMSBz3i9kYGexYZRS8t6_cNgCCSlu2JlHFmXUlVKsICdCF4BUxb5cXmOD/pub   
- Консольная программа на базе php8 (laravel). Парсит данные об исполнителе и его библиотеке треков c сайта soundcloud.com в базу данных по url исполнителя.
- Имеется поддержка DOCKER
- Код покрыт тестами
```bash
php artisan test
```

## Установка

- клонируйте репозиторий
- создайте файл .env.php по аналогии с env.example.php и заполните настройки подключения к вашей бд и измените настройки парсинга soundcloud, если необходимо.
- composer install
- для запуска тестов создайте тестовую БД
```bash
 touch database/database.sqlite
```

## Использование

```bash
php artisan soundcloud:load https://soundcloud.com/dekobe
```
