<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 | Akses Ditolak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-retro-bg px-6">

<div class="max-w-xl w-full">
    <div class="bg-white border-4 border-retro-border shadow-retro-lg rounded-xl overflow-hidden">

        <!-- HEADER -->
        <div class="bg-yellow-300 border-b-4 border-retro-border p-8 text-center">
            <h1 class="text-7xl font-black tracking-widest">403</h1>
            <p class="mt-2 text-xl font-bold uppercase">Akses Ditolak</p>
        </div>

        <!-- CONTENT -->
        <div class="p-8 text-center space-y-6">
            <p class="text-gray-700">
                Kamu tidak memiliki izin untuk mengakses halaman ini.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="history.back()"
                        class="btn-retro-outline">
                    Kembali
                </button>

                <a href="{{ url('/') }}"
                   class="btn-retro-primary">
                    Ke Beranda
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="bg-retro-muted border-t-4 border-retro-border p-4 text-center text-sm">
            DISTROZONE • Error 403
        </div>
    </div>
</div>

</body>
</html>
