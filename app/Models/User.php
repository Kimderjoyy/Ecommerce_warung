<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'is_active',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the cart items for the user.
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the reviews for the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive users.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include customer users.
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    /**
     * Scope a query to filter by search term.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's initials (first letter of first name and last name).
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get the user's first initial.
     */
    public function getFirstInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Fallback to UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=100&background=10b981&color=ffffff';
    }

    /**
     * Get the user's role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return $this->role === 'admin' ? 'Administrator' : 'Pelanggan';
    }

    /**
     * Get the user's status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Get the user's status color.
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'green' : 'red';
    }

    /**
     * Get the user's role color.
     */
    public function getRoleColorAttribute(): string
    {
        return $this->role === 'admin' ? 'red' : 'green';
    }

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedDateAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    /**
     * Get formatted created date with time.
     */
    public function getFormattedCreatedDateTimeAttribute(): string
    {
        return $this->created_at->format('d M Y H:i');
    }

    /*
    |--------------------------------------------------------------------------
    | REVIEW METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user has reviewed a specific product.
     *
     * @param int $productId
     * @return bool
     */
    public function hasReviewed($productId): bool
    {
        return $this->reviews()->where('product_id', $productId)->exists();
    }

    /**
     * Get user's review for a specific product.
     *
     * @param int $productId
     * @return \App\Models\Review|null
     */
    public function getReviewForProduct($productId)
    {
        return $this->reviews()->where('product_id', $productId)->first();
    }

    /**
     * Check if user has purchased a specific product.
     *
     * @param int $productId
     * @return bool
     */
    public function hasPurchasedProduct($productId): bool
    {
        return $this->orders()
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status', 'delivered')
            ->exists();
    }

    /**
     * Get all products that user can review (purchased and not reviewed yet).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReviewableProducts()
    {
        $purchasedProductIds = $this->orders()
            ->whereHas('items')
            ->where('status', 'delivered')
            ->with('items.product')
            ->get()
            ->pluck('items.*.product_id')
            ->flatten()
            ->unique();

        $reviewedProductIds = $this->reviews()->pluck('product_id');

        $reviewableIds = $purchasedProductIds->diff($reviewedProductIds);

        return Product::whereIn('id', $reviewableIds)->get();
    }

    /**
     * Get user's reviews with product details.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReviewsWithProduct()
    {
        return $this->reviews()->with('product')->latest()->get();
    }

    /**
     * Get average rating given by user.
     *
     * @return float
     */
    public function getAverageRatingGivenAttribute(): float
    {
        return (float) $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count.
     *
     * @return int
     */
    public function getTotalReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get approved reviews count.
     *
     * @return int
     */
    public function getApprovedReviewsCountAttribute(): int
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    /**
     * Get pending reviews count.
     *
     * @return int
     */
    public function getPendingReviewsCountAttribute(): int
    {
        return $this->reviews()->where('is_approved', false)->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if user is inactive.
     */
    public function isInactive(): bool
    {
        return !$this->is_active;
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(): void
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    /**
     * Activate user.
     */
    public function activate(): void
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     * Deactivate user.
     */
    public function deactivate(): void
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * Get total orders count.
     */
    public function getTotalOrdersCount(): int
    {
        return $this->orders()->count();
    }

    /**
     * Get total spent amount (from delivered orders).
     */
    public function getTotalSpent(): float
    {
        return (float) $this->orders()
            ->where('status', 'delivered')
            ->sum('total_amount');
    }

    /**
     * Get total spent amount (from all orders).
     */
    public function getTotalSpentAll(): float
    {
        return (float) $this->orders()->sum('total_amount');
    }

    /**
     * Get last order.
     */
    public function getLastOrder()
    {
        return $this->orders()->latest()->first();
    }

    /**
     * Get last 5 orders.
     */
    public function getLastOrders($limit = 5)
    {
        return $this->orders()->latest()->limit($limit)->get();
    }

    /**
     * Get pending orders count.
     */
    public function getPendingOrdersCount(): int
    {
        return $this->orders()->where('status', 'pending')->count();
    }

    /**
     * Get processing orders count.
     */
    public function getProcessingOrdersCount(): int
    {
        return $this->orders()->where('status', 'processing')->count();
    }

    /**
     * Get delivered orders count.
     */
    public function getDeliveredOrdersCount(): int
    {
        return $this->orders()->where('status', 'delivered')->count();
    }

    /**
     * Get cancelled orders count.
     */
    public function getCancelledOrdersCount(): int
    {
        return $this->orders()->where('status', 'cancelled')->count();
    }

    /**
     * Check if user has orders.
     */
    public function hasOrders(): bool
    {
        return $this->orders()->exists();
    }

    /**
     * Check if user has any pending orders.
     */
    public function hasPendingOrders(): bool
    {
        return $this->orders()->where('status', 'pending')->exists();
    }

    /**
     * Delete avatar file.
     */
    public function deleteAvatar(): void
    {
        if ($this->avatar) {
            \Storage::disk('public')->delete($this->avatar);
            $this->avatar = null;
            $this->save();
        }
    }

    /**
     * Update avatar.
     */
    public function updateAvatar($file): string
    {
        // Delete old avatar
        if ($this->avatar) {
            \Storage::disk('public')->delete($this->avatar);
        }
        
        // Store new avatar
        $path = $file->store('avatars', 'public');
        $this->avatar = $path;
        $this->save();
        
        return $path;
    }

    /**
     * Get role badge class.
     */
    public function getRoleBadgeClass(): string
    {
        return $this->role === 'admin' 
            ? 'bg-red-500/20 text-red-400 border-red-500/30' 
            : 'bg-green-500/20 text-green-400 border-green-500/30';
    }

    /**
     * Get role dot class.
     */
    public function getRoleDotClass(): string
    {
        return $this->role === 'admin' ? 'bg-red-500' : 'bg-green-500';
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClass(): string
    {
        return $this->is_active 
            ? 'bg-green-500/20 text-green-400 border-green-500/30' 
            : 'bg-red-500/20 text-red-400 border-red-500/30';
    }

    /**
     * Get status dot class.
     */
    public function getStatusDotClass(): string
    {
        return $this->is_active ? 'bg-green-500' : 'bg-red-500';
    }
}