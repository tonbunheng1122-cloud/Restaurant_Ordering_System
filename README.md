# FastBite — System 
## INSTALL (PHP 8.4 , LARAVEL 12)
<!-- PHP 8.4 version -->
composer update
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate (SELCET) -> yes FOR Create table on BD
<!-- Tailwindcss -->
npm install tailwindcss @tailwindcss/vite
<!-- RUN FOR Store Picture -->
php artisan storage:link

## RUN (Open Terminal)
RUN FOR MAC : npm run dev & php artisan serve 
RUN FOR WINDONW : npm run dev , (NEW TERMINAL) : php artisan serve 

## RUN INSERT USERNAME AND PASSWORD FOR LOGIN WHEN DELETE DEFAULT ADMIN RUN THE THIS COMMAND
<!-- LOGIN USERNAME AND PASSWORD -->
php artisan db:seed --class=AdminSeeder