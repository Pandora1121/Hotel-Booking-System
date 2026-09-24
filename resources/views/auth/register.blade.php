<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Kirana Hotel & Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Manrope', ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Fraunces', serif; }
    </style>
</head>
<body class="bg-[#FAF9F6]">
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Panel kiri: ilustrasi skyline malam (sama seperti login, konsisten) --}}
        <div class="relative hidden lg:flex lg:w-[55%] overflow-hidden bg-gradient-to-b from-[#0B1620] to-[#182C3D]">
            <svg viewBox="0 0 600 800" preserveAspectRatio="xMidYMax slice" class="absolute inset-0 w-full h-full">
                <defs>
                    <radialGradient id="moonGlow" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#F4E7C4" stop-opacity="0.35"/>
                        <stop offset="100%" stop-color="#F4E7C4" stop-opacity="0"/>
                    </radialGradient>
                </defs>

                <circle cx="470" cy="130" r="100" fill="url(#moonGlow)"/>
                <circle cx="470" cy="130" r="30" fill="#F4E7C4"/>

                <rect x="30" y="300" width="210" height="500" fill="#0C1B26"/>
                <rect x="275" y="195" width="270" height="605" fill="#0A1620"/>

                @for ($row = 0; $row < 10; $row++)
                    @for ($col = 0; $col < 5; $col++)
                        <rect x="{{ 54 + $col * 36 }}" y="{{ 322 + $row * 44 }}" width="16" height="24"
                              fill="#E8C56A"
                              opacity="{{ ($row * 5 + $col) % 3 == 0 ? 0.9 : ((($row + $col) % 4 == 0) ? 0.45 : 0.08) }}" />
                    @endfor
                @endfor

                @for ($row = 0; $row < 12; $row++)
                    @for ($col = 0; $col < 6; $col++)
                        <rect x="{{ 296 + $col * 37 }}" y="{{ 220 + $row * 44 }}" width="18" height="26"
                              fill="#E8C56A"
                              opacity="{{ ($row * 6 + $col) % 4 == 0 ? 0.85 : ((($row + $col * 2) % 5 == 0) ? 0.4 : 0.07) }}" />
                    @endfor
                @endfor
            </svg>

            <div class="relative z-10 flex flex-col justify-between w-full px-14 py-14">
                <div class="font-display text-2xl text-white">
                    Kirana <span class="text-[#C9A227]">Hotel &amp; Resort</span>
                </div>

                <div class="max-w-sm">
                    <p class="font-display text-2xl text-white/90 leading-snug mb-4">
                        &ldquo;Kamar terbaik menanti, cukup beberapa langkah dari sekarang.&rdquo;
                    </p>
                    <p class="text-sm text-white/45">Tim Reservasi, Kirana Hotel &amp; Resort</p>
                </div>
            </div>
        </div>

        {{-- Panel kanan: form register --}}
        <div class="flex flex-1 items-center justify-center px-6 py-12 lg:px-16">
            <div class="w-full max-w-sm">

                <div class="lg:hidden mb-10 font-display text-xl text-[#12202B]">
                    Kirana <span class="text-[#C9A227]">Hotel &amp; Resort</span>
                </div>

                <h1 class="font-display text-3xl text-[#12202B] mb-2">Buat akun baru</h1>
                <p class="text-sm text-gray-500 mb-8">Daftar untuk mulai memesan kamar impian Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-[#12202B] mb-1.5">Nama lengkap <span class="text-[#C9A227]">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               autocomplete="name" placeholder="Nama sesuai KTP"
                               class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#12202B] mb-1.5">Alamat email <span class="text-[#C9A227]">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               autocomplete="username" placeholder="nama@email.com"
                               class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#12202B] mb-1.5">Nomor WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               autocomplete="tel" placeholder="08xxxxxxxxxx"
                               class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                        <p class="mt-1.5 text-xs text-gray-400">Dipakai untuk kirim notifikasi status booking.</p>
                        @error('phone')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-[#12202B] mb-1.5">Kata sandi <span class="text-[#C9A227]">*</span></label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[#12202B] mb-1.5">Ulangi kata sandi <span class="text-[#C9A227]">*</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               autocomplete="new-password" placeholder="Ulangi kata sandi di atas"
                               class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                        @error('password_confirmation')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-[#12202B] text-white text-sm font-medium py-3 rounded-lg hover:bg-[#1B2F3D] transition-colors">
                        Daftar
                    </button>
                </form>

                <p class="mt-8 text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#12202B] font-medium hover:text-[#C9A227]">Masuk di sini</a>
                </p>
            </div>
        </div>

    </div>
</body>
</html>