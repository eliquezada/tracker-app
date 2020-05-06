# tacker-app
Time tacker task

# setup environment
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
