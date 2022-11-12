<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Storage;

class AccountController extends Controller
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
        try {
            $name = isset($request->name) ? $request->name : "";
            $profileImage = isset($request->profile_image) ? $request->profile_image : "";
            $profileUrl = "";

            $account = new Account();
            $account->name = $name;
            $account->save();
            if (!empty($profileImage)) {
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $profileImage));
                $imageName = $this->quickRandom(30) . '.png';
                $p = Storage::disk('s3')->put('account/profile/' . $account->id . '/' . $imageName, $image, 'public');
                $domain = 'https://cu-mentor-bucket.s3.ap-southeast-1.amazonaws.com/';
                $profileUrl  = $domain . 'account/profile/' . $account->id . '/' . $imageName;
                $account = Account::find($account->id);
                $account->profile_url = $profileUrl;
                $account->save();
            }

            $response = array(
                "success" =>  true,
                "message" => "create account successfully",
                "data" => $account
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
        //
    }

    public function updateProfileImage(Request $request, $id)
    {
        try {
            $profileImage = isset($request->profile_image) ? $request->profile_image : "";
            $profileUrl = "";
            if (!empty($profileImage)) {
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $profileImage));
                $imageName = $this->quickRandom(30) . '.png';
                $p = Storage::disk('s3')->put('account/profile/' . $id . '/' . $imageName, $image, 'public');
                $domain = 'https://cu-mentor-bucket.s3.ap-southeast-1.amazonaws.com/';
                $profileUrl  = $domain . 'account/profile/' . $id . '/' . $imageName;
                // return $profileUrl;
            }

            $account = Account::find($id);
            $account->profile_url = $profileUrl;
            $account->save();

            $response = array(
                "success" =>  true,
                "message" => "update account successfully",
                "data" => $account
            );
            return response($response, 201);
            
        } catch (\Exception $e) {

            return $e->getMessage();
        }
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

    public function getTaggedList(Request $request)
    {
        try {
            $orderBy = $request->query('orderby');
            $accounts = DB::table('post_account_mapping')
                ->join('accounts', 'post_account_mapping.account_id', '=', 'accounts.id')
                ->select('accounts.id as id', 'accounts.name as name', DB::raw("count(accounts.id) as count"),'accounts.profile_url as profile_url')
                ->groupBy('accounts.id')
                ->orderBy("count", $orderBy)
                ->get();
            $response = array(
                "success" =>  true,
                "message" => "get account successfully",
                "data" => $accounts
            );
            return response($response, 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function getAccountList()
    {
        try {
            $accounts = Account::where("deleted_at",null)->get();
            $response = array(
                "success" =>  true,
                "message" => "get account successfully",
                "data" => $accounts
            );
            return response($response, 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
