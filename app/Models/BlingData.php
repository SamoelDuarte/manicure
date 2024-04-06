<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'expires_in',
        'token_type',
        'scope',
        'refresh_token',
    ];
}