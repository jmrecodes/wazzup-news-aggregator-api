# Steps to setup on local machine:

1. Place .env file to the root dir or you can use .env.example by running cp .env.example .env (News Aggregation task scheduled commands won't work this way due to lacking the API keys to authenticate the calls)
2. Open terminal on the root dir
3. Run docker-compose build --no-cache && docker-compose up -d
4. docker-compose exec app composer install
5. docker-compose exec app php artisan key:generate
6. docker-compose exec app php artisan --env=testing key:generate
7. docker-compose exec app php artisan migrate:fresh --seed
8. docker compose exec \
  -e DB_CONNECTION=sqlite \
  -e DB_DATABASE=/var/www/html/database/testing.sqlite \
  app php artisan test --env=testing
9. docker-compose exec app php artisan schedule:work (need authenticateed API keys to work)
10. visit: http://localhost:7700 or http://localhost:7700/api/documentatio
