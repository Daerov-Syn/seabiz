<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')
                ->with('status', 'error')
                ->with('message', 'Google login belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET terlebih dahulu.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')
                ->with('status', 'error')
                ->with('message', 'Google login belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET terlebih dahulu.');
        }

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('status', 'error')
                ->with('message', 'Gagal masuk lewat Google. Coba lagi.');
        }

        $email = $googleUser->getEmail();
        $user = User::where('email', $email)->first();

        if (! $user) {
            $username = $this->makeUniqueUsername($googleUser->getNickname() ?: $googleUser->getName() ?: explode('@', $email)[0]);

            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: $username,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make(Str::random(24)),
                'avatar' => $googleUser->getAvatar(),
                'role' => 'pengguna',
            ]);
        } else {
            if (! $user->username) {
                $user->username = $this->makeUniqueUsername($googleUser->getNickname() ?: $googleUser->getName() ?: explode('@', $email)[0]);
            }

            if (! $user->avatar) {
                $user->avatar = $googleUser->getAvatar();
            }

            $user->save();
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'))
            ->with('status', 'success')
            ->with('message', 'Berhasil masuk lewat Google.');
    }

    private function makeUniqueUsername(string $base): string
    {
        $base = Str::slug($base ?: 'user');
        $candidate = substr($base, 0, 45);
        $counter = 1;

        while (User::where('username', $candidate)->exists()) {
            $candidate = substr($base, 0, 45 - strlen((string) $counter)) . $counter;
            $counter++;
        }

        return $candidate;
    }
}
