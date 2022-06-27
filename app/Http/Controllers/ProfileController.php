<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $userId = $id;
        $collectionName = isset($request->collection_name) ? $request->collection_name : "";
        $parasUrl = isset($request->paras_url) ? $request->paras_url : "";
        $discordUrl = isset($request->discord_url) ? $request->discord_url : "";
        $twitterUrl = isset($request->twitter_url) ? $request->twitter_url : "";
        $collectionBase64 = isset($request->collection_base64) ? $request->file("collection_base64") : "";
        $platformId = isset($request->platform_id) ? $request->platform_id : "";
        $cryptoUrl = isset($request->crypto_url) ? $request->crypto_url : "";
        $facebookUrl = isset($request->facebook_url) ? $request->facebook_url : "";
        $utility = isset($request->utility) ? $request->utility : "";


        $collectionUrl = "";
        if (!empty($collectionBase64)) {
            $p = Storage::disk('s3')->put('documents/' . $userId . '/collection', $collectionBase64, 'public');
            $domain = 'https://worldnftevent.s3.us-east-2.amazonaws.com/';
            $collectionUrl = $domain . $p;
        }

        $user = User::find($userId);
        $user->paras_url = $parasUrl;
        $user->discord_url = $discordUrl;
        $user->twitter_url = $twitterUrl;
        $user->crypto_url = $cryptoUrl;
        $user->collection_name = $collectionName;
        $user->platform_id = $platformId;
        $user->facebook_url = $facebookUrl;
        $user->utility = $utility;
        if (!empty($collectionUrl)) {
            $user->collection_url = $collectionUrl;
        }
        $user->save();
        $response = array(
            "success" =>  true,
            "message" => "update profile successfully",
            "data" => $user
        );
        return response($response, 201);
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
}
