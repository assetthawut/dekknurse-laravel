<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $response = array(
            "success" =>  true,
            "message" => "get user by id successfully",
            "data" => $user
        );
        return response($response,201);
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

    public function login(Request $request)
    {
        $user = User::where("name",$request->username)->first();
        if (!$user || !Hash::check($request->password,$user->password)) {
            $response = array(
                "success" =>  false,
                "message" => "this credentials do not match our record",
                "data" => []
            );
            return response($response,404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        $data = [
            'user' => $user,
            'token' => $token
        ];
        $response = array(
            "success" =>  true,
            "message" => "login successfully",
            "data" => $data
        );
        return response($response,201);
    }

    public function verifyToken(){
        $data = array(
            "is_valid"=> true
        );
        $response = array(
            "success" =>  true,
            "message" => "verify token succesfull",
            "data" => $data
        );
        return $response;
    }

    public function mostActiveUser($platformId){
        // Most active user in 7 days
        $users =DB::table('users')->select("users.*", DB::raw('COUNT(events.user_id) as total'))
                ->join('events', 'events.user_id', '=', 'users.id')
                ->where('users.platform_id', '=', $platformId)
                ->where( 'events.created_at', '>', Carbon::now()->subDays(7))
                ->groupBy('events.user_id')
                ->orderBy('total', 'desc')
                ->skip(0)
                ->take(10)
                ->get();
        return $users;
    }
}


// verifyToken