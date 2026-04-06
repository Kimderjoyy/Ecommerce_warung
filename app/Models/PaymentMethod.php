<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'icon',
        'description',
        'instructions',
        'config',
        'is_active',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope untuk mengambil metode pembayaran yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope untuk mengambil metode pembayaran berdasarkan kode
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Ambil konfigurasi tertentu
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get icon HTML
     */
    public function getIconHtmlAttribute()
    {
        return '<i class="fas ' . $this->icon . '"></i>';
    }

    /**
     * Get formatted name with icon
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . strtoupper($this->code) . ')';
    }
}