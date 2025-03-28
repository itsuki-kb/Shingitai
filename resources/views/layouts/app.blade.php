<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts -->
    {{-- 和風で読みやすいフォント（Noto Sans JP） --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine JS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-stone-100 text-stone-800 bg-[url('/public/images/washi-white.jpg')] bg-cover bg-center">
    <div class="min-h-screen flex flex-col">
        {{-- ナビゲーション --}}
        @include('layouts.navigation')

        {{-- メイン --}}
        <main class="w-full max-w-5xl min-w-[640px] mx-auto px-4 py-6 min-h-[60vh]">
            {{ $slot }}
        </main>

        {{-- フッター（任意） --}}
        <footer class="text-center text-xs text-stone-500">
            &copy; {{ date('Y') }} Shingitai
        </footer>
    </div>
</body>
</html>

