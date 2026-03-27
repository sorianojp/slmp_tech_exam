# JSONPlaceholder Laravel API

A complete Laravel application that fetches data from the external JSONPlaceholder API via a custom Artisan command, stores it in a local database using Eloquent, and serves it through a secure RESTful API using Laravel Sanctum.

## Features

* Custom Artisan console command for external API consumption.
* Automatic database seeding using Eloquent `updateOrCreate`.
* Secure token authentication via Laravel Sanctum.
* Full RESTful CRUD routing for nested and standalone resources.

## Setup Instructions

1. **Clone the repository:**
   `git clone https://github.com/username/jsonplaceholder-api.git`
   `cd jsonplaceholder-api`

2. **Install dependencies:**
   `composer install`

3. **Environment Setup:**
   Copy the example environment file:
   `cp .env.example .env`
   
   Generate the application key:
   `php artisan key:generate`

4. **Database Setup:**
   Configure your database in the `.env` file. By default, Laravel uses SQLite.
   Run the migrations to create the tables:
   `php artisan migrate`

5. **Fetch and Seed Data:**
   Run the custom Artisan command to populate the database with users, posts, comments, albums, photos, and todos:
   `php artisan app:fetch-placeholder-data`

6. **Serve the Application:**
   `php artisan serve`

## Authentication Guide

This API uses Laravel Sanctum. You must authenticate to receive a Bearer Token to access the protected endpoints.

1. **Obtain a Token:**
   * Make a `POST` request to `http://localhost:8000/api/login`.
   * Send the following JSON body credentials:
     * `email`: Sincere@april.biz
     * `password`: password123
   * The response will contain your plain text token.

2. **Access Protected Routes:**
   * Add an `Authorization` header to your subsequent requests.
   * Set the value to `Bearer your_generated_token_here`.

## Testing with Postman

A complete Postman Collection is available for testing all endpoints. 
Simply import the `JSONPlaceholder_Laravel_API.postman_collection.json` file (if included in the repo) or manually configure the routes below. The login route in the provided collection automatically sets the Bearer token as a global variable for seamless testing.

## Available Endpoints

**Public:**
* `POST /api/login`

**Protected (Require Bearer Token):**
* `GET /api/posts`
* `GET /api/posts/{id}`
* `POST /api/posts`
* `PUT /api/posts/{id}`
* `DELETE /api/posts/{id}`
* `GET /api/posts/{postId}/comments`
* `GET /api/comments`
* `GET /api/comments?postId={id}`
* `GET /api/albums`
* `GET /api/photos`
* `GET /api/todos`
* `GET /api/users`