
### DESCRIPTION
- Консольная программа на базе php8 (laravel). Парсит данные об исполнителе и его библиотеке треков c сайта soundcloud.com в базу данных по url исполнителя.
- Имеется поддержка DOCKER
## Установка

- клонируйте репозиторий
- создайте файл .env.php по аналогии с env.example.php и заполните настройки подключения к вашей бд и измените настройки парсинга soundcloud, если необходимо.
- composer install

## Использование

```bash
php artisan soundcloud:load https://soundcloud.com/dekobe
```
