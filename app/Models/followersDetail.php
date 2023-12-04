<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followersDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'Users_id',
        'Users_followers_id',
    ];
}
