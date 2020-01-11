# Laravel 6 PMS
Simple Payroll Management System in Laraval 6
## Installation

Install all dependencies packages via composer

```
composer update
```

Run the migration and seed with dummy data.

```
php artisan migrate --seed
```

And run the web server

```
php artisan serve
```

Now, visit  http://127.0.0.1:8000 

## Notes

If you have front-end issues, you can run below cmds.(project's frontend dependencies using NPM. Once the dependencies have been installed using npm install, you can compile your SASS files to plain CSS using Laravel Mix.)
```
npm install
npm run dev
```
