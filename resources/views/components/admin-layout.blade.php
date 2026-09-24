<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Kirana Hotel & Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Manrope', ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Fraunces', serif; }
    </style>
</head>
<body class="bg-[#F7F6F3]">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#12202B] text-white flex flex-col shrink-0">
            <div class="px-6 py-6 font-display text-lg border-b border-white/10">
                Kirana <span class="text-[#C9A227]">Admin</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.hotels.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.hotels.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    Hotels
                </a>
                <a href="{{ route('admin.room-types.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.room-types.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    Room Types
                </a>
                <a href="{{ route('admin.rooms.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.rooms.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    Rooms
                </a>
                <a href="{{ route('admin.bookings.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    Bookings
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <h1 class="font-display text-xl text-[#12202B]">{{ $title ?? 'Dashboard' }}</h1>
            </header>

            <main class="flex-1 p-8">
                @if (session('success'))
                    <div class="mb-6 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>