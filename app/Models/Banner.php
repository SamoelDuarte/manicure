<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Permission\Traits\HasRoles;

class Banner extends Model
{
    use HasFactory, Notifiable, SearchableTrait, HasRoles;
    protected $table = "banners";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'status',
        'image',
    ];


    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

}
