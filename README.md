# tacker-app
Time tacker task can be run with Docker or Manually

# setup environment with Docker
1. Install docker https://docs.docker.com/

2. Clone repo and inside repo run
    <pre>
    docker-compose build app
    docker-compose up -d
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate:fresh
    </pre>
    
3. Site is ready at http://127.0.0.1:8000

# setup environment manually
1. Install composer preferable globally
https://getcomposer.org/download/
    <pre>
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    </pre>
        
2. Make composer globally
    <pre>
    mv composer.phar /usr/local/bin/composer
    php -r "unlink('composer-setup.php');"
    </pre>
    
3. Install node js and npm  
https://docs.npmjs.com/downloading-and-installing-node-js-and-npm
    
# **tracker-app**
4. Clone this repo inside **tracker-app**
    rename .env.example to .env and update db credentials

5. Install package and dependencies including Laravel
    composer install
    
6. php artisan key:generate

7. php artisan migrate

8. php artisan serve

**That's all, thank you!**
