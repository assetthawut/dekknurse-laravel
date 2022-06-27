<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');
        $platformId = $request->query('platform_id');

        // join with user 
        $events = Event::select('events.*')->where("deleted_at", null)
            ->join('users', 'users.id', '=', 'events.user_id')
            ->whereDate("public_date", ">=", $start)
            ->whereDate("public_date", "<=", $end)
            ->where("users.platform_id", $platformId)
            ->get();

        /*
$leagues = League::select('league_name')
    ->join('countries', 'countries.country_id', '=', 'leagues.country_id')
    ->where('countries.country_name', $country)
    ->get();
        */

        $response = array(
            "success" =>  true,
            "message" => "get event list successfully",
            "data" => $events
        );
        return response($response, 201);
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
        $userId = isset($request->user_id) ? $request->user_id : "";
        $publicDate = isset($request->public_date) ? $request->public_date : "";
        $collectionBase64 = isset($request->collection_base64) ? $request->file("collection_base64") : "";
        $description = isset($request->description) ? $request->description : "";

        $collectionUrl = "";

        if (!empty($collectionBase64)) {
            $p = Storage::disk('s3')->put('documents/' . $userId . '/event/collection', $collectionBase64, 'public');
            $domain = 'https://worldnftevent.s3.us-east-2.amazonaws.com/';
            $collectionUrl = $domain . $p;
        }



        $event = new Event();
        $event->user_id = $userId;
        if (!empty($collectionUrl)) {
            $event->collection_url = $collectionUrl;
        }
        $event->public_date = $publicDate;
        $event->description = $description;
        $event->views = 0;
        $event->save();
        $this->sendLineNotify($event->id, "created");
        $response = array(
            "success" =>  true,
            "message" => "create event successfully",
            "data" => $event
        );
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        $response = array(
            "success" =>  true,
            "message" => "get event by id successfully",
            "data" => $event
        );
        return response($response, 201);
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
        $userId = isset($request->user_id) ? $request->user_id : "";
        $publicDate = isset($request->public_date) ? $request->public_date : "";
        $collectionBase64 = isset($request->collection_base64) ? $request->file("collection_base64") : "";
        $description = isset($request->description) ? $request->description : "";

        $collectionUrl = "";
        if (!empty($collectionBase64)) {
            $p = Storage::disk('s3')->put('documents/' . $userId . '/collection', $collectionBase64, 'public');
            $domain = 'https://worldnftevent.s3.us-east-2.amazonaws.com/';
            $collectionUrl = $domain . $p;
        }
        $event = Event::find($id);
        $event->user_id = $userId;
        if (!empty($collectionBase64)) {
            $event->collection_url = $collectionUrl;
        }
        $event->public_date = $publicDate;
        $event->description = $description;
        $event->save();
        $this->sendLineNotify($event->id, "updated");
        $response = array(
            "success" =>  true,
            "message" => "update event successfully",
            "data" => $event
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
        $now = Carbon::now();
        $event = Event::where("deleted_at", null)->where("id", $id)->first();
        if (!empty($event)) {
            $event->deleted_at = $now;
            $event->save();
        }
        $response = array(
            "success" =>  true,
            "message" => "delete event successfully",
            "data" =>  (object)[]
        );
        return $response;
    }

    // getEventByUserId 
    public function getEventByUserId($id)
    {
        $today = Carbon::today()->toDateString();
        $events = Event::where("deleted_at", null)
            ->whereDate("public_date", '>=', $today)
            ->where("user_id", $id)->get();
        $response = array(
            "success" =>  true,
            "message" => "get event by id successfully",
            "data" => $events
        );
        return response($response, 201);
    }

    // updateEventViews
    public function updateEventViews(Request $request)
    {
        $eventId = isset($request->event_id) ? $request->event_id : "";
        // return $eventId;
        // $views = isset($request->views) ? $request->views : "";   
        $event = Event::where("id", $eventId)->where("deleted_at", null)->first();
        if ($event) {
            $event->views = $event->views + 1;
            $event->save();
            $response = array(
                "success" =>  true,
                "message" => "update event views successfully",
                "data" => $event
            );
            return response($response, 201);
        }
    }

    public function sendLineNotify($eventId = 1, $eventType = "created")
    {
        /*
        Event updated
        ...
        Collection : Chingchong
        📌 Date : Friday 25 May 2022 | 9.00PM
        ...
        See event detail
        https://worldnftevent.com/paras
     */
        // Event created , updated 
        $event = Event::where("id", $eventId)->where("deleted_at", null)->first();
        $url        = 'https://notify-api.line.me/api/notify';
        $token      = '2aFpmrp6cqYq4d8dNWyBxwAkQKKu6Q2yjLgORdAJuzj';
        $headers    = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        ];
        // return $event;
        $eventDateTime = Carbon::parse($event->public_date)->format('D d F Y | g.iA');
        $eventUrl  = "";
        $eventTime = "";

        switch ($event->user->platform_id) {
            case 1:
                $eventUrl = "https://worldnftevent.com/paras";
                break;
            case 2:
                $eventUrl = "";
                break;
            case 3:
                $eventUrl = "";
                break;
            case 4:
                $eventUrl = "https://worldnftevent.com/crypto";
                break;
            default:
                $eventUrl = "https://worldnftevent.com/paras";
        }

        $message = "        
Event {$eventType}
...
Collection : {$event->user->collection_name}
📌 Date : {$eventDateTime}
...
See event detail
{$eventUrl}";

        $fields     = 'message=' . $message;
        // return $message;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        var_dump($result);
        $result = json_decode($result, TRUE);
        return $result;
        // return $event;
    }

    public function sendNotifyOneHrBeforeEventPublish()
    {
        $currentDateTime = Carbon::now();
        $newDateTime = $currentDateTime->addHour();
        // Query events 
        // Loop and send Notify 
        $events = Event::where("deleted_at",null)
                        ->where("public_date",$newDateTime->format('Y-m-d H:i'))
                        // 2022-05-21 16:24
                        // ->where("public_date","2022-05-21 16:25")
                        ->get();
        foreach($events as $event){
            $url        = 'https://notify-api.line.me/api/notify';
            $token      = '2aFpmrp6cqYq4d8dNWyBxwAkQKKu6Q2yjLgORdAJuzj';
            $headers    = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $token
            ];
            // return $event;
            $eventDateTime = Carbon::parse($event->public_date)->format('D d F Y  g.iA');
            $eventUrl  = "";
            $eventTime = "";
    
            switch ($event->user->platform_id) {
                case 1:
                    $eventUrl = "https://worldnftevent.com/paras";
                    break;
                case 2:
                    $eventUrl = "";
                    break;
                case 3:
                    $eventUrl = "";
                    break;
                case 4:
                    $eventUrl = "https://worldnftevent.com/crypto";
                    break;
                default:
                    $eventUrl = "https://worldnftevent.com/paras";
            }
    
            $message = "        
🔥🔥🔥 Upcoming Event
Collection : {$event->user->collection_name}
...
⏰ Event will start in 60 minutes
...
📌 Date :{$eventDateTime} GMT+7
...
See detail
{$eventUrl}
            ";
    
            $fields     = 'message=' . $message;
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
    
            var_dump($result);
            $result = json_decode($result, TRUE);       
        }
    }
}
