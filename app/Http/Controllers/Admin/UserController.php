<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Build query with filters - TAMBAHKAN withCount
        $query = User::withCount(['orders', 'reviews']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Get paginated results
        $users = $query->latest()->paginate(12);

        // Calculate statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $customerCount = User::where('role', 'customer')->count();
        $newUsers = User::whereMonth('created_at', now()->month)->count();
        $newCustomers = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->count();
        $activeToday = User::whereDate('updated_at', today())->count();
        
        // Review statistics
        $totalReviews = Review::count();
        $pendingReviews = Review::where('is_approved', false)->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminCount',
            'customerCount',
            'newUsers',
            'newCustomers',
            'activeToday',
            'totalReviews',
            'pendingReviews'
        ));
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['orders' => function ($query) {
                        $query->latest()->limit(5);
                    }])
                    ->withCount(['orders', 'reviews'])
                    ->findOrFail($id);
        
        $orderCount = $user->orders()->count();
        $totalSpent = $user->orders()->where('status', 'delivered')->sum('total_amount');
        $lastOrder = $user->orders()->latest()->first();
        
        // Get user's reviews with product details
        $reviews = Review::with('product')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();
        
        if (request()->ajax()) {
            return view('admin.users.detail', compact('user', 'orderCount', 'totalSpent', 'lastOrder', 'reviews'));
        }
        
        return view('admin.users.show', compact('user', 'orderCount', 'totalSpent', 'lastOrder', 'reviews'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate request
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,customer',
            'is_active' => 'nullable|boolean',
        ];

        // Add password validation if provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        // Add avatar validation if uploaded
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Handle avatar removal
        if ($request->input('remove_avatar') === '1') {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = null;
        }

        // Hash password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active');

        // Update user
        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin users
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus user admin.');
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete user
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Status user berhasil diubah.',
        ]);
    }

    /**
     * Get user detail for AJAX.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        $user = User::with(['orders' => function ($query) {
                        $query->latest()->limit(5);
                    }])
                    ->withCount(['orders', 'reviews'])
                    ->findOrFail($id);
        
        $orderCount = $user->getTotalOrdersCount();
        $totalSpent = $user->getTotalSpent();
        $lastOrder = $user->getLastOrder();
        
        // Get user's reviews with product details
        $reviews = Review::with('product')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

        return view('admin.users.detail', compact('user', 'orderCount', 'totalSpent', 'lastOrder', 'reviews'));
    }
}