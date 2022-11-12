<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAccountMapping extends Model
{
    use HasFactory;
    protected $table = 'post_account_mapping';
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
