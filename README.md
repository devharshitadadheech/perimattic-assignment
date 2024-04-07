# Perimattic Assignment

[![Github](https://img.shields.io/badge/Github-HarshitaDadheech-blue.svg)](https://github.com/devharshitadadheech)

Description: 

## Features

- Site Monitoring
- Contact Management

## Installation
```php
php --version // >=8.0.2
composer --version // >=2.7.2
```


```php
git clone "repo url"
cd "name of the folder you cloned"
composer install
cp .env.example .env
php artisan key:generate
//add env parameter values like database and smtp credentials
php artisan migrate --seed
php artisan serve // local server
php artisan schedule:run // as a daemon command, you can use cron job, pm2 anything
```

## Usage

Visit [localhost](http://localhost:8000/). It will display a login form. Provide credentials and login.
