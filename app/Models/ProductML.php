<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductML extends Model
{
    use HasFactory;
    protected $table = "product_ml";
    protected $fillable = [
        'id_ml',
        'id_conta_ml',
        'permalink',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function conta_ml()
    {   
        return $this->belongsTo(MercadoLivreData::class, 'id_conta_ml');
    }
}
