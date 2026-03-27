# JSONPlaceholder Laravel API

A complete Laravel application that fetches data from the external JSONPlaceholder API via a custom Artisan command, stores it locally using SQLite, and serves it through a secure RESTful API using Laravel Sanctum.

## Setup Instructions

1. **Clone the repository:**
   `git clone https://github.com/yourusername/jsonplaceholder-api.git`
   `cd slmp_tech_exam`

2. **Install dependencies:**
   `composer install`

3. **Environment Setup:**
   Copy the example environment file:
   `cp .env.example .env`
   
   Ensure your database connection is set to SQLite in the `.env` file:
   `DB_CONNECTION=sqlite`

4. **Initialize Docker (Laravel Sail):**
   Build and start the Docker containers in the background:
   `./vendor/bin/sail up -d`

5. **Database Setup & Migrations (Inside Docker):**
   Generate the application key and run migrations within the Docker environment:
   `./vendor/bin/sail artisan key:generate`
   `./vendor/bin/sail artisan migrate`

6. **Fetch and Seed Data (Inside Docker):**
   Run the custom Artisan command inside the Docker container to populate the database:
   `./vendor/bin/sail artisan app:fetch-placeholder-data`

7. **Access the Application:**
   The API is now running inside Docker and is accessible at `http://localhost`.

## Authentication Guide

This API uses Laravel Sanctum. You must authenticate to receive a Bearer Token to access the protected endpoints.

1. **Obtain a Token:**
   * Make a `POST` request to `http://localhost/api/login`.
   * Send the following JSON or form-data credentials:
     * `email`: Sincere@april.biz
     * `password`: password123
   * The response will contain your plain text token.

2. **Access Protected Routes:**
   * Add an `Authorization` header to your subsequent requests.
   * Set the value to `Bearer your_generated_token_here`.

## Testing with Postman

A complete Postman Collection is included in the repository for testing all endpoints. Import the `postman-collection.json` file into Postman. The login route automatically sets the Bearer token as a global variable for seamless testing across all other routes.