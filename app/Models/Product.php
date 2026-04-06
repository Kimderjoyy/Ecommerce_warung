<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Mendapatkan rating rata-rata (hanya review yang disetujui)
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    // Mendapatkan total review (hanya yang disetujui)
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->approved()->count();
    }

    // Mendapatkan review yang disetujui
    public function getApprovedReviewsAttribute()
    {
        return $this->reviews()->approved()->with('user')->latest()->get();
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}