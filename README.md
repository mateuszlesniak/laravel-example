<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

> Note: When running application for the first time (or hasn't got **vendor** folder) simply run:
> ```bash
> docker run --rm \
>    -u "$(id -u):$(id -g)" \
>    -v "$(pwd):/var/www/html" \
>    -w /var/www/html \
>    laravelsail/php82-composer:latest \
>    composer install --ignore-platform-reqs
> ```

1. Run `./vendor/bin/sail build`
1. When project will be built run `./vendor/bin/sail up -d`
1. To run migrations for database run `./vendor/bin/sail artisan migrate`

## API

* Under **./routes** folder exists latest postman collection for all available API routes.

## Testing

#### Report

Current report for project files:
![docs/coverage_report.png](docs/coverage_report.png)

> For CLI report you can run `./vendor/bin/sail  artisan test --coverage`

1. To generate tests report use `./vendor/bin/sail artisan test --coverage-html ./.coverage` command
1. Report will be generated in **./.coverage** folder. Open *index.html* file to review it

#### Run tests
1. Run command `./vendor/bin/sail artisan test` to run all tests
