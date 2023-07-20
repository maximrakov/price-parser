Инструкция для запуска 
1. cp .env .env.example
2. docker-compose up
3. docker-compose exec php npm run install
4. docker-compose exec php npm run build
5. docker-compose exec php composer install
6. docker-compose exec php php artisan key:generate
7. docker-compose exec php php artisan migrate
8. docker-compose exec php php artisan parse:products
9. docker-compose exec php php artisan queue:work --timeout=1000 (можно запустить несколько воркеров)
10. docker-compose exec php php artisan queue:listen --queue=parsingQueue --timeout=1000 (можно запустить несколько воркеров)
11. docker-compose exec php php artisan queue:listen --queue=updatingQueue --timeout=1000 (можно запустить несколько воркеров)
    12. docker-compose exec php php artisan schedule:run
