<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Account;
use App\Models\Sibling;
use App\Models\PostAccountMapping;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['comments','accounts','siblings'];

    public function getAccountsAttribute()
    {
        $postAccountMapping = PostAccountMapping::select('account_id as id')->where("post_id",$this->id)->get();
        $accounts = Account::whereIn('id', $postAccountMapping)->get();
        return $accounts;
    }

    public function getCommentsAttribute()
    {
        $comments = Comment::where("post_id",$this->id)->where("deleted_at",null)->get();
        return $comments;
    }

    public function getSiblingsAttribute()
    {
        $siblings = Sibling::where("parent_id",$this->id) ->orderBy('id', 'desc')->get();
        return $siblings;
    }
}
