web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate:fresh --seed --force && ln -sr storage/app/public public/storage

