<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $appends = ['user',"public_date_end"];

    public function getUserAttribute()
    {
        $userId = $this->user_id;
        $user = User::where("id",$userId)->first();
        return (!empty( $user))? $user:(object)[];
    }

    public function getPublicDateEndAttribute()
    {
        return Carbon::parse($this->public_date)
        ->addSeconds(1)
        ->format('Y-m-d H:i:s');
    }
}
