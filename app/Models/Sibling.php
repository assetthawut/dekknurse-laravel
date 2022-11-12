<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Account;

class Sibling extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['account'];

    public function getAccountAttribute()
    {
        $account = Account::find($this->account_id);
        return $account;
    }

}
