<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'branch',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Scope untuk mengambil rekening yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format nomor rekening (contoh: 1234 5678 9012)
     */
    public function getFormattedAccountAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->account_number);
        // Format: setiap 4 digit beri spasi
        return trim(chunk_split($number, 4, ' '));
    }

    /**
     * Mendapatkan 4 digit terakhir nomor rekening
     */
    public function getLastFourAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->account_number);
        return substr($number, -4);
    }

    /**
     * Nomor rekening yang di-mask (**** **** 1234)
     */
    public function getMaskedAccountAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->account_number);
        $length = strlen($number);
        
        if ($length <= 4) {
            return str_repeat('*', $length);
        }
        
        $lastFour = substr($number, -4);
        $masked = str_repeat('*', $length - 4);
        
        // Format dengan spasi setiap 4 karakter
        $maskedWithSpaces = trim(chunk_split($masked, 4, ' '));
        return $maskedWithSpaces . ' ' . $lastFour;
    }

    /**
     * Nama display lengkap (BCA a.n. John Doe)
     */
    public function getDisplayNameAttribute()
    {
        return $this->bank_name . ' a.n. ' . $this->account_name;
    }

    /**
     * Informasi rekening lengkap untuk ditampilkan
     */
    public function getFullInfoAttribute()
    {
        return "{$this->bank_name} - {$this->formatted_account} ({$this->account_name})";
    }

    /**
     * Cek apakah rekening ini adalah rekening utama
     */
    public function isMain()
    {
        return $this->id === 1; // Atau logika lain sesuai kebutuhan
    }
}