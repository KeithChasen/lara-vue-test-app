#!/usr/bin/env bash

DIR="$( cd "$( dirname "$0" )" && pwd )"

echo "Installing composer";
chmod -v +x ${DIR}/composer.sh
${DIR}/composer.sh

#check if there's .env file
if [ ! -f ${DIR}/../.env ];

then
echo "file .env doesn't exist. Please create .env file, fill it and run install.sh again";
exit

else

cd ${DIR}/..

sudo chmod 777 -R bootstrap/cache
sudo chmod 777 -R storage

php artisan key:generate

php artisan jwt:secret

php artisan cache:clear

echo Doing migrations

php artisan migrate

echo Filling Data Base with test data

php artisan db:seed --class=RolesSeeder
php artisan db:seed --class=AdminSeeder

exit

fi
