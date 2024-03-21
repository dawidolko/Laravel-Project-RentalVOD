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

## Contribution
Contributions are welcome! Please feel free to contribute by submitting pull requests or by reporting bugs and suggesting new features through the issues section.

## License
This project is licensed under the MIT License - see the [LICENSE](https://github.com/dawidolko/Laravel-Project-RentalVOD/blob/main/LICENSE) file for details.
