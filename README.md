Инструкция для запуска 
1. cp .env .env.example
2. php artisan key:generate
3. docker compose up
4. docker exec price-parser-app-1 php artisan:migrate
5. docker exec price-parser-app-1 php artisan parse:products
6. docker exec price-parser-app-1 php artisan queue:listen --timeout=240
7. docker exec price-parser-app-1 php artisan schedule:run
