<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HashtagController extends Controller
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
            $hashtags = DB::select("
            SELECT word
                , COUNT(*) total
            FROM 
                ( SELECT DISTINCT id
                                , SUBSTRING_INDEX(SUBSTRING_INDEX(hashtags,' ',i+1),' ',-1) word
                            FROM posts
                                , ints 
                ) x
            GROUP BY word HAVING COUNT(*) > 0 ORDER BY total $orderBy, word;
            ");
            $response = array(
                "success" =>  true,
                "message" => "get account successfully",
                "data" => $hashtags
            );
            return response($response, 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
