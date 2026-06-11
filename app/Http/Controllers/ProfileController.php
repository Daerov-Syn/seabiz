<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.akun', [
            'currentUser' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone,
                'bio' => $user->bio,
                'avatar' => $user->avatar,
                'birth_date' => $user->birth_date,
                'gender' => $user->gender,
                'role' => $user->role,
                'seller_name' => $user->seller_name,
                'seller_description' => $user->seller_description,
                'seller_phone' => $user->seller_phone,
                'seller_address' => $user->seller_address,
                'seller_revenue' => $user->seller_revenue,
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:1'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->fill(array_filter($data, fn ($value) => $value !== null && $value !== ''));
        $user->save();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone,
                'bio' => $user->bio,
                'avatar' => $user->avatar,
                'birth_date' => $user->birth_date,
                'gender' => $user->gender,
                'role' => $user->role,
                'seller_name' => $user->seller_name,
                'seller_description' => $user->seller_description,
                'seller_phone' => $user->seller_phone,
                'seller_address' => $user->seller_address,
                'seller_revenue' => $user->seller_revenue,
            ],
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Password lama tidak sesuai.'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function becomeSeller(Request $request)
    {
        $user = Auth::user();

        if ($user->isSeller()) {
            return redirect()->route('seller.profile');
        }

        $user->forceFill([
            'role' => 'penjual',
            'seller_name' => $request->input('seller_name', $user->name),
            'seller_description' => $request->input('seller_description', 'Toko resmi SeaBiz'),
            'seller_phone' => $request->input('seller_phone', $user->phone),
            'seller_address' => $request->input('seller_address', ''),
            'seller_revenue' => 0,
        ]);
        $user->save();

        return redirect()->route('seller.profile')->with('status', 'success')->with('message', 'Akun Anda berhasil terdaftar sebagai penjual.');
    }

    public function sellerDashboard()
    {
        $user = Auth::user();

        if (! $user->isSeller()) {
            return redirect()->route('akun')->with('status', 'error')->with('message', 'Daftarkan diri sebagai penjual terlebih dahulu.');
        }

        $products = $user->products()->latest()->get();

        return view('profile.seller', compact('user', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $user = Auth::user();

        if (! $user->isSeller()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $user->products()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'unit' => $data['unit'] ?? 'kg',
            'image' => $data['image'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('seller.profile')->with('status', 'success')->with('message', 'Produk berhasil ditambahkan.');
    }

    public function destroyProduct(
        \App\Models\Product $product
    ) {
        $user = Auth::user();

        if ($product->user_id !== $user->id) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('seller.profile')->with('status', 'success')->with('message', 'Produk berhasil dihapus.');
    }
}
