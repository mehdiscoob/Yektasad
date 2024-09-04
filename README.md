# Product Management System

## Introduction

This is a Laravel-based Product Management System that includes functionalities for managing products, carts, and their respective operations. It includes endpoints for adding products to a cart, removing items, and retrieving cart details, along with scheduled tasks for clearing expired carts.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Fetching Articles](#fetching-articles)
- [API Documentation](#api-documentation)
- [Running Tests](#running-tests)
- [Scheduled Tasks](#scheduled-tasks)
- [Dockerization](#dockerization)
- [Contributing](#contributing)

## Features

- User authentication and registration
- Aggregation of news articles from multiple sources
- Article search and filtering by keyword, date, category, and source
- Personalized news feed based on user preferences
- API documentation with Swagger

## Requirements

- Docker and Docker Compose
- PHP 8.0+
- Composer
- MySQL or PostgreSQL

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/mehdiscoob/Yektasad.git
    cd Yektasad
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Copy and modify the `.env` file:
    ```bash
    cp .env.example .env
    ```

   Configure the database connection and other environment variables in the `.env` file.

4. Generate an application key:
    ```bash
    php artisan key:generate
    ```

5. Run the database migrations:
    ```bash
    php artisan migrate
    ```

6. Install Swagger for API documentation:
    ```bash
    php artisan l5-swagger:generate
    ```

## Running the Application

### Using Docker

1. Build and start the containers:
    ```bash
    docker-compose up --build
    ```

2. The application will be available at `http://localhost:8000`.

### Without Docker

1. Start the Laravel development server:
    ```bash
    php artisan serve
    ```

2. The application will be available at `http://localhost:8000`.

## API Documentation

The API documentation is generated using Swagger. After running the application, you can access the API documentation
at:

[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

### API Endpoints

**User Authentication**

- `POST /register`: Register a new user
- `POST /login`: Log in a user
- `POST /logout`: Log out a user (Requires authentication)

**Products**

- `POST /products`: Create a new product (name, price, stock), (Requires authentication)

**Carts**

- `POST /cart`: Adds a product to the user's cart. (Requires authentication)
- `DELETE /cart/item/{itemId}`: Removes a product from the user's cart. (Requires authentication)
- `GET /cart`: Retrieve the current user's cart. (Requires authentication)

## Running Tests

The project includes tests to ensure the functionality works as expected. To run the tests, use:

### Running `php artisan test`

#### With Docker

If you're using Docker, you can run the `php artisan test` command within your Docker container. This command executes any scheduled tasks defined in your Laravel application.

```bash
docker exec -it laravel-app php artisan test
````

## Scheduled Tasks

To automatically fetch articles from various sources every day, the application is configured to run the `FetchArticlesCommand` daily. This command retrieves articles and stores them in the local database.

To set up the scheduled task, ensure that your server's cron jobs are configured to run Laravel's scheduler. The command to schedule is:

### Running `php artisan schedule:work`

#### With Docker

If you're using Docker, you can run the `php artisan schedule:work` command within your Docker container. This command executes any scheduled tasks defined in your Laravel application.

```bash
docker exec -it laravel-app php artisan schedule:work
````
## Dockerization

This Laravel application can be Dockerized for easy development and deployment.

### Prerequisites

Ensure Docker and Docker Compose are installed on your machine.

### Configuration

Use the provided `docker-compose.yml` to define services: MySQL and Nginx.

### Building & Running

1. Navigate to project root.
2. Build containers: `docker-compose build`.
3. Start containers: `docker-compose up`.

Access the app at [http://localhost:9000](http://localhost:9000).

### Customization

- Adjust environment variables in `docker-compose.yml`.
- Modify Nginx configuration in `nginx.conf`.

### Development

Use Docker for local development, enabling immediate code changes.

### Deployment

Adapt `docker-compose.yml` and Nginx config for production. Consider Docker Swarm or Kubernetes for orchestration.


## Contributing
We welcome contributions to the project. To contribute:

1. Fork the repository.
2. Create a new feature branch.
3. Make your changes.
4. Submit a pull request.

Please ensure your code follows best practices and includes appropriate tests.

