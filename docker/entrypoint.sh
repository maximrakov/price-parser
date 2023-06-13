
/usr/bin/supervisord -n &
if [ ! -f ".env" ]; then
    cp .env.example .env
fi
php artisan serve --host 0.0.0.0 &
php artisan key:generate
npm run dev --host 0.0.0.0
