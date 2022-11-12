<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostAccountMapping;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $detail = isset($request->detail) ? $request->detail : "";
            $hashtags = isset($request->hashtags) ? $request->hashtags : "";
            $accountIds = isset($request->account_id) ? $request->account_id : "";
            $parentId = isset($request->parent_id) ? $request->parent_id : null;
            $url = isset($request->url) ? $request->url : "";

            $post = new Post();
            $post->detail = $detail;
            $post->hashtags = $hashtags;
            // $post->account_id = $accountId;
            $post->parent_id = $parentId;
            $post->url = $url;
            $post->save();

            foreach($accountIds as $key => $value) {
                $postAccountMapping = new PostAccountMapping();
                $postAccountMapping->post_id = $post->id;
                $postAccountMapping->account_id  = $value;
                $postAccountMapping->save();
            }
            $response = array(
                "success" =>  true,
                "message" => "create post successfully",
                "data" => $post
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::where("deleted_at",null)
                    ->where("id",$id)
                    ->first();
            $response = array(
                "success" =>  true,
                "message" => "get post successfully",
                "data" => $post
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPostList()
    {
        try {
            $posts = Post::where("deleted_at",null)
                    ->orderBy('likes', 'DESC')
                    ->orderBy('retweets', 'DESC')
                    ->orderBy('favorites', 'DESC')
                    ->get();
            $response = array(
                "success" =>  true,
                "message" => "get post successfully",
                "data" => $posts
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getlatestPostList()
    {
        try {
            $posts = Post::where("deleted_at",null)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            $response = array(
                "success" =>  true,
                "message" => "get post successfully",
                "data" => $posts
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // likePost
    public function likePost()
    {
    }

    public function retweetPost(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            $post->retweets = $post->retweets + 1;
            $post->save();
            $response = array(
                "success" =>  true,
                "message" => "retweet post successfully",
                "data" => $post
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
    }

    public function favoritePost(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            $post->favorites = $post->favorites + 1;
            $post->save();
            $response = array(
                "success" =>  true,
                "message" => "favorite post successfully",
                "data" => $post
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
    }

    public function createSiblingPost(Request $request){
        try {
            $detail = isset($request->detail) ? $request->detail : "";
            $hashtags = isset($request->hashtags) ? $request->hashtags : "";
            $accountIds = isset($request->account_id) ? $request->account_id : "";
            $parentId = isset($request->parent_id) ? $request->parent_id : null;
            $url = isset($request->url) ? $request->url : "";

            $post = new Post();
            $post->detail = $detail;
            $post->hashtags = $hashtags;
            $post->parent_id = $parentId;
            $post->url = $url;
            $post->save();
            foreach($accountIds as $key => $value) {
                $postAccountMapping = new PostAccountMapping();
                $postAccountMapping->post_id = $post->id;
                $postAccountMapping->account_id  = $value;
                $postAccountMapping->save();
            }
            $response = array(
                "success" =>  true,
                "message" => "create sibling post successfully",
                "data" => $post
            );
            return response($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
    }
}
