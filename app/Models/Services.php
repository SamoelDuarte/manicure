<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['name', 'value', 'duration_minutes'];
}
