<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Todo;

class ApiController extends Controller
{
    /**
     * Authenticate user and issue Sanctum token.
     */
    public function login(Request $request)
    {
        $request->validate(array(
            'email' => 'required|email',
            'password' => 'required',
        ));

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            
            return response()->json(array(
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ));
        }

        return response()->json(array('message' => 'Unauthorized'), 401);
    }

    // ==========================================
    // POSTS: Full RESTful CRUD Operations
    // ==========================================

    /**
     * Display a listing of the posts. (GET /api/posts)
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * Store a newly created post. (POST /api/posts)
     */
    public function store(Request $request)
    {
        $request->validate(array(
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ));

        $post = Post::create(array(
            'user_id' => Auth::id(), // Automatically assign to the logged-in user
            'title' => $request->title,
            'body' => $request->body
        ));

        return response()->json($post, 201);
    }

    /**
     * Display the specified post. (GET /api/posts/{id})
     */
    public function show($id)
    {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(array('message' => 'Post not found'), 404);
        }
        
        return response()->json($post);
    }

    /**
     * Update the specified post. (PUT/PATCH /api/posts/{id})
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(array('message' => 'Post not found'), 404);
        }

        // Only update the fields that were actually passed in the request
        $post->update($request->only('title', 'body'));
        
        return response()->json($post);
    }

    /**
     * Remove the specified post. (DELETE /api/posts/{id})
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(array('message' => 'Post not found'), 404);
        }

        $post->delete();
        
        return response()->json(array('message' => 'Post deleted successfully'));
    }

    // ==========================================
    // NESTED RESOURCES & QUERY PARAMETERS
    // ==========================================

    /**
     * Get comments for a specific post. (GET /api/posts/{postId}/comments)
     */
    public function getPostComments($postId)
    {
        // Verify the post exists first
        if (!Post::where('id', $postId)->exists()) {
            return response()->json(array('message' => 'Post not found'), 404);
        }

        $comments = Comment::where('post_id', $postId)->get();
        return response()->json($comments);
    }

    /**
     * Get all comments, or filter by postId. 
     * Handles: GET /api/comments AND GET /api/comments?postId=1
     */
    public function getComments(Request $request) 
    { 
        if ($request->has('postId')) {
            return response()->json(Comment::where('post_id', $request->query('postId'))->get());
        }
        
        return response()->json(Comment::all()); 
    }

    // ==========================================
    // OTHER RESOURCE GETTERS
    // ==========================================
    
    public function getAlbums() 
    { 
        return response()->json(Album::all()); 
    }
    
    public function getPhotos() 
    { 
        // Capping at 100 to prevent performance issues with 5000 records
        return response()->json(Photo::limit(100)->get()); 
    }
    
    public function getTodos() 
    { 
        return response()->json(Todo::all()); 
    }
    
    public function getUsers() 
    { 
        return response()->json(User::all()); 
    }
}