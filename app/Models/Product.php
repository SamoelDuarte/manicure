<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $searchable = [

        'columns' => [
            'products.name' => 10,
            'products.slug' => 10
        ],
    ];
    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }
 
    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] == 0 ? 'Inactive' : 'Active';
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeHasQuantity($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->whereStatus(1);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }

    public function getFeaturedAttribute(): string
    {
        return $this->attributes['featured'] == 0 ? 'No' : 'Yes';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->wherePivot('quantity');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->whereStatus(1);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function firstMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->orderBy('file_sort', 'asc');
    }
    public function productML()
    {
        return $this->hasOne(ProductML::class, 'product_id');
    }

    public function hasProductML()
    {
        return $this->productML()->exists();
    }
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function rate()
    {
        return $this->ratings->isNotEmpty() ? $this->ratings()->sum('value') / $this->ratings()->count() : 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        // Você pode ajustar a lógica de formatação conforme necessário
        $formattedPrice = number_format($this->attributes['price'], 2, ',', '.');

        return  $formattedPrice;
    }
    public function getCreatedAtFormattedAttribute(): string
    {
        // Converte a data para um objeto Carbon para fácil manipulação
        $createdAt = Carbon::parse($this->attributes['created_at']);

        // Formata a data no formato desejado
        return $createdAt->format('d/m/Y');
    }
}
