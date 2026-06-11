<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// ─── Landing Page (publik) ────────────────────────────────────────────
Route::get('/', fn() => view('home.index'))->name('index');

// ─── Auth GET ─────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    fn() => view('auth.login'))   ->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');

    Route::post('/login', function (Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = ['password' => $request->password];
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['username'] = $request->username;
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('status', 'success')->with('message', 'Berhasil masuk.');
        }

        return redirect()->route('login')->withInput()->with('status', 'error')->with('message', 'Username atau password salah.');
    })->name('login.post');

    Route::post('/register', function (Request $request) {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'pengguna',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('status', 'success')->with('message', 'Akun berhasil dibuat.');
    })->name('register.post');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

// ─── Halaman Utama (perlu login) ──────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',   fn() => view('home.dashboard'))      ->name('dashboard');
    Route::get('/marketplace', fn() => view('katalog.marketplace')) ->name('marketplace');
    Route::get('/info-harga',  fn() => view('home.info_harga'))     ->name('info-harga');
    Route::get('/cerita-umkm', fn() => view('home.cerita_umkm'))    ->name('cerita-umkm');
    Route::get('/keranjang',   fn() => view('home.keranjang'))      ->name('keranjang');
    Route::get('/checkout',    fn() => view('home.checkout'))       ->name('checkout');
    Route::post('/checkout/place-order', [OrderController::class, 'store'])->name('checkout.place-order');
    Route::post('/checkout/confirm-payment', [OrderController::class, 'confirmPayment'])->name('checkout.confirm-payment');
    Route::get('/pesanan',     [OrderController::class, 'index'])   ->name('pesanan');
    Route::get('/notifikasi',  fn() => view('home.notifikasi'))     ->name('notifikasi');
    Route::get('/akun', [ProfileController::class, 'index'])->name('akun');
    Route::post('/akun/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/akun/change-password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/akun/become-seller', [ProfileController::class, 'becomeSeller'])->name('seller.upgrade');
    Route::get('/seller/profil', [ProfileController::class, 'sellerDashboard'])->name('seller.profile');
    Route::post('/seller/products', [ProfileController::class, 'storeProduct'])->name('seller.products.store');
    Route::delete('/seller/products/{product}', [ProfileController::class, 'destroyProduct'])->name('seller.products.destroy');
});
