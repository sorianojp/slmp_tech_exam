<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Todo;

#[Signature('app:fetch-placeholder-data')]
#[Description('Fetches all data from JSONPlaceholder and inserts it into the database using Eloquent')]
class FetchJsonPlaceholderData extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://jsonplaceholder.typicode.com';

        $this->info('Fetching Users...');
        $users = Http::get("$baseUrl/users")->json();
        foreach ($users as $user) {
            User::updateOrCreate(
                ['id' => $user['id']],
                [
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'password' => Hash::make('password123'), // Default password for testing
                ]
            );
        }

        $this->info('Fetching Posts...');
        $posts = Http::get("$baseUrl/posts")->json();
        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['id' => $post['id']],
                ['user_id' => $post['userId'], 'title' => $post['title'], 'body' => $post['body']]
            );
        }

        $this->info('Fetching Comments...');
        $comments = Http::get("$baseUrl/comments")->json();
        foreach ($comments as $comment) {
            Comment::updateOrCreate(
                ['id' => $comment['id']],
                ['post_id' => $comment['postId'], 'name' => $comment['name'], 'email' => $comment['email'], 'body' => $comment['body']]
            );
        }

        $this->info('Fetching Albums...');
        $albums = Http::get("$baseUrl/albums")->json();
        foreach ($albums as $album) {
            Album::updateOrCreate(
                ['id' => $album['id']],
                ['user_id' => $album['userId'], 'title' => $album['title']]
            );
        }

        $this->info('Fetching Photos...');
        $photos = Http::get("$baseUrl/photos")->json();
        foreach ($photos as $photo) {
            Photo::updateOrCreate(
                ['id' => $photo['id']],
                ['album_id' => $photo['albumId'], 'title' => $photo['title'], 'url' => $photo['url'], 'thumbnailUrl' => $photo['thumbnailUrl']]
            );
        }

        $this->info('Fetching Todos...');
        $todos = Http::get("$baseUrl/todos")->json();
        foreach ($todos as $todo) {
            Todo::updateOrCreate(
                ['id' => $todo['id']],
                ['user_id' => $todo['userId'], 'title' => $todo['title'], 'completed' => $todo['completed']]
            );
        }

        $this->info('All data fetched and stored successfully!');
    }
}
