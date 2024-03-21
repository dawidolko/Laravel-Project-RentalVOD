# VOD (Video On Demand) Platform Project

## Introduction
Welcome to the VOD Platform Project, a Laravel-based solution designed for streaming movies on demand. This platform allows users to instantly rent movies online and gain immediate access to their favorite titles. The project aims to offer a seamless and user-friendly experience for movie enthusiasts, with a wide selection of titles available for streaming. This VOD service emphasizes ease of use, accessibility, and customer satisfaction, providing an enriched viewing experience for all registered users.

## Project Setup

### Requirements
- PHP >= 8.1
- Composer
- MySQL (MariaDB 10.6 or higher) or a compatible database
- Laravel 9.x
- Node.js and NPM (for compiling assets)
- Stripe for secure online payment processing

### Installation
1. Clone the repository to your local machine.
2. Navigate to the project directory and execute `composer install` to install PHP dependencies.
3. Create a `.env` file from the `.env.example` template and configure your database and Stripe payment gateway settings.
4. Execute `php artisan key:generate` to generate the application key.
5. Execute `php artisan migrate` to create the database schema.
6. (Optional) Execute `php artisan db:seed` to populate the database with sample data.
7. Execute `php artisan serve` to start the local development server.

## Features
- **User Registration and Authentication**: Secure system for user sign-up and login.
- **Extensive Movie Catalog**: Explore a vast collection of movies available for instant streaming.
- **Instant Access After Purchase**: Users gain immediate access to movies after completing the purchase.
- **Payment Processing**: Integration with Stripe for handling payments securely.
- **User Dashboard**: Users can manage their profiles, view purchase history, and access rented movies.
- **Administrator Control Panel**: Administrators can manage the movie catalog, user accounts, and view transaction histories.
- **Responsive Design**: Ensuring a great user experience across various devices and screen sizes.

## Technologies
- **Laravel 9.x**: The latest version of the Laravel framework, providing a robust foundation for web application development.
- **MySQL/MariaDB**: For secure and reliable data storage.
- **Stripe**: For secure handling of online transactions and payment processing.
- **Bootstrap 5**: For designing a responsive and mobile-first user interface.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
