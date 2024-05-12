unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    *)          machine="UNKNOWN:${unameOut}"
esac

if [ "$machine" == "Mac" ]; then
    /Applications/xampp/xamppfiles/bin/mysql -uroot -e "CREATE DATABASE IF NOT EXISTS rentalVOD;"  # Mac
elif [ "$machine" == "Linux" ]; then
    /opt/lampp/bin/mysql -uroot -e "CREATE DATABASE IF NOT EXISTS rentalVOD;" # Linux
else
    echo ${machine}
    (exit 0)
fi

if [ $? -eq 1 ]; then
   echo "Nie udalo sie utworzyc bazy danych."
   exit
fi

php -r "copy('.env.example', '.env');"

composer install

# composer update

composer require stripe/stripe-php

composer require bensampo/laravel-enum

php artisan key:generate

php artisan storage:link

# php artisan migrate

# php artisan db:seed

php artisan migrate:fresh --seed

php artisan serve

code .
