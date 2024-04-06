<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercadoLivreData extends Model
{
    use HasFactory;
    protected $table = "mercado_livre";
    protected $fillable = [
        'access_token',
        'refresh_token',
        'user_id',
        'id_ml',
        'nickname',
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'permalink',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
