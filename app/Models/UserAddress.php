<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserAddress extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'user_addresses.title' => 10,
            'user_addresses.zipcode' => 10,
            'user_addresses.addres' => 10,
            'user_addresses.neighborhood' => 10,
            'user_addresses.state' => 10,
            'user_addresses.city' => 10,
            'user_addresses.complement' => 10,
            'user_addresses.number' => 10,
        ],
        'joins' => [
            'users' => ['users.id', 'user_addresses.user_id']
        ]
    ];

   

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
