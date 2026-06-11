@extends('layouts.auth')

@section('title', 'Login — SeaBiz')

@section('styles')
<style>
    .bg-complex {
        background: radial-gradient(circle at top, rgba(29, 155, 240, 0.15), transparent 28%), #f6f9ff;
    }
    .bg-complex::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: radial-gradient(circle at 20% 10%, rgba(29, 155, 240, 0.15), transparent 10%),
                          radial-gradient(circle at 80% 20%, rgba(72, 201, 176, 0.2), transparent 12%);
        pointer-events: none;
        z-index: -1;
    }
    .visual-overlay::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 28% 22%, rgba(29, 155, 240, 0.15), transparent 24%),
                    radial-gradient(circle at 80% 32%, rgba(72, 201, 176, 0.16), transparent 16%);
        pointer-events: none;
    }
</style>
@endsection

@section('content')
@php
    $status  = session('status', '');
    $message = session('message', '');
@endphp

<main class="min-h-screen grid place-items-center p-5 md:p-8 bg-complex">
    <section class="w-full max-w-[1100px] grid grid-cols-1 lg:grid-cols-[1.1fr_0.95fr] gap-6 md:gap-9">

        {{-- Panel kiri: visual --}}
        <article class="relative min-h-[420px] md:min-h-[480px] lg:min-h-[560px] bg-gradient-to-b from-[#e8f5ff] to-white rounded-[28px] lg:rounded-[32px] border border-slate-900/10 shadow-[0_32px_80px_rgba(15,23,42,0.08)] overflow-hidden visual-overlay hidden sm:block">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80"
                 alt="Pantai dan laut" class="absolute inset-0 w-full h-full object-cover object-center scale-[1.03]" />
            <div class="absolute inset-0 flex flex-col justify-between gap-6 p-8 lg:p-10 text-slate-900 z-10">
                <div>
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-emerald-500/10 text-slate-900 font-semibold text-sm backdrop-blur-md w-max">
                        <span class="w-8 h-8 grid place-items-center rounded-full bg-white shadow-md">🌊</span> SeaBiz
                    </div>
                    <h1 class="text-[clamp(2rem,2.7vw,3.4rem)] leading-[1.02] mt-6 text-[#0b2441] font-extrabold tracking-tight">
                        Bangun bisnis perikanan Anda dengan tampilan modern dan profesional.
                    </h1>
                    <p class="max-w-[420px] mt-4 text-base leading-[1.8] text-slate-700 font-medium">
                        Masuk ke akun Anda untuk mengelola pesanan, memantau stok, dan menjangkau pelanggan lebih luas dengan marketplace SeaBiz.
                    </p>
                </div>
            </div>
        </article>

        {{-- Panel kanan: form login --}}
        <article class="bg-white p-8 md:p-11 flex flex-col justify-center rounded-[28px] lg:rounded-[32px] border border-slate-900/10 shadow-[0_32px_80px_rgba(15,23,42,0.08)]">

            <h1 class="text-[clamp(2rem,2.2vw,2.6rem)] mb-2 font-extrabold text-slate-900 tracking-tight">Login</h1>
            <p class="text-brand-muted mb-4 leading-[1.75] max-w-[420px] font-medium">Welcome back! Please login to your account.</p>

            @if($status || $message)
            <div id="authFlash" class="fixed top-4 right-4 z-50 max-w-sm rounded-2xl border px-5 py-4 text-sm font-semibold shadow-xl backdrop-blur
                {{ $status === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-rose-50 border-rose-200 text-rose-900' }}">
                <div class="flex items-center gap-2">
                    <span class="text-base">{{ $status === 'success' ? '✅' : '⚠️' }}</span>
                    <span>{{ $message }}</span>
                </div>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="post">
                @csrf

                <div class="grid gap-2 mb-4">
                    <label for="username" class="block font-semibold text-slate-900 text-sm">Username / Gmail</label>
                    <input id="username" name="username" type="text"
                           placeholder="Masukkan username atau email"
                           required autocomplete="username"
                           class="w-full border border-slate-900/10 rounded-2xl px-5 py-4 text-[15px] text-brand-dark bg-[#f8fbff] outline-none transition-all focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10" />
                </div>

                <div class="grid gap-2 mb-4">
                    <div class="flex justify-between items-center text-[13px] text-brand-muted mb-1">
                        <label for="password" class="font-semibold text-slate-900 text-sm">Password</label>
                        <a href="#" class="text-brand-blue font-semibold hover:underline">Lupa Password?</a>
                    </div>
                    <div class="flex gap-2">
                        <input id="password" name="password" type="password"
                               placeholder="••••••••" required autocomplete="current-password"
                               class="flex-1 border border-slate-900/10 rounded-2xl px-5 py-4 text-[15px] text-brand-dark bg-[#f8fbff] outline-none transition-all focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10" />
                        <button type="button" onclick="togglePassword()"
                                class="px-4 border border-slate-900/10 rounded-2xl bg-white font-semibold text-slate-800 hover:border-brand-blue/30 hover:-translate-y-px transition-all">👁️</button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full mt-3.5 px-5 py-4 border-none rounded-2xl text-white bg-gradient-to-br from-[#1d9bf0] to-[#1645b4] text-base font-bold cursor-pointer transition-all hover:-translate-y-px hover:shadow-[0_20px_40px_rgba(29,155,240,0.24)]">
                    Login
                </button>
            </form>

            <p class="mt-7 text-sm text-brand-muted font-medium">
                Tidak punya akun?
                <a href="{{ route('register') }}" class="text-brand-blue font-semibold hover:underline">Daftar disini</a>
            </p>

        </article>
    </section>
</main>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        const field = document.getElementById('password');
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const flash = document.getElementById('authFlash');
        if (flash) {
            setTimeout(() => {
                flash.classList.add('opacity-0', 'translate-y-2');
            }, 3500);
            setTimeout(() => flash.remove(), 4000);
        }
    });
</script>
@endsection
