After cloning the project, need to run following command 
- Using docker-compose exec backend {command}


    - composer install
    - cp .env.example .env
    - chmod o+w ./storage/ -R
    - php artisan key:generate
    - php artisan storage:link
    - php artisan config:cache
    - php artisan config:clear
    - php artisan migrate
    - php artisan db:seed

