
Oktrening test tast.


1. After cloning the project, build images and run containers:
    

    - docker-compose up -d

2. You may check if conatainers running successfully by command:
    

    - docker ps -a

3. If something is wrong with containers, you can check logs. Example:


    - docker-compose logs nginx

4. After containers successfully running, using [docker-compose exec backend {command}], run following commands:


    - composer install
    - cp .env.example .env
    - chmod o+w ./storage/ -R
    - php artisan key:generate
    - php artisan storage:link
    - php artisan config:cache
    - php artisan config:clear
    - php artisan migrate
    - php artisan db:seed

Backend runs on regular http port 80
PphMyAdmin runs on port 8080
MySQQL runs on standard 3306 port
Redis runs on standard 6379 port

Postman documentation is in file Documentation.json