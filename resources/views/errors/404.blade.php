<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Halaman Tidak Ditemukan - Lokachara</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .text-brand-blue {
            color: #1A6DFF;
        }

        .bg-brand-blue {
            background-color: #1A6DFF;
        }

        .hover\:bg-brand-blue-dark:hover {
            background-color: #1558CC;
        }

        .text-brand-green {
            color: #03C988;
        }

        .bg-brand-green {
            background-color: #03C988;
        }

        .text-brand-yellow {
            color: #FFCE3F;
        }

        .bg-brand-yellow {
            background-color: #FFCE3F;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50 flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Background Gradients / Decorative Orbs -->
    <div class="absolute top-0 left-0 -mt-20 -ml-20 w-80 h-80 bg-brand-blue/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 -mb-20 -mr-20 w-80 h-80 bg-brand-yellow/15 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-brand-green/5 rounded-full blur-3xl -z-10"></div>

    <div class="container max-w-2xl mx-auto px-4 text-center z-10">
        <!-- Brand Logo -->
        <div class="flex justify-center mb-8">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="Lokachara" class="h-12">
            </a>
        </div>

        <!-- Glassmorphism Card -->
        <div class="bg-white/70 backdrop-blur-md border border-gray-100 rounded-3xl p-8 md:p-12 shadow-xl">
            <!-- Animated 404 Icon / Illustration -->
            <div class="relative w-48 h-48 mx-auto mb-8 flex items-center justify-center">
                <div class="absolute inset-0 bg-brand-blue/10 rounded-full animate-pulse"></div>
                <div class="absolute inset-4 bg-brand-blue/5 rounded-full animate-ping duration-1000"></div>
                
                <!-- Compass / Travel icon styling -->
                <svg class="w-24 h-24 text-brand-blue relative z-10 transform hover:rotate-45 transition-transform duration-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>

            <!-- Error Heading -->
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Rute Tidak Ditemukan
            </h1>
            
            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                Sepertinya Anda tersesat di luar peta perjalanan kami. Halaman yang Anda tuju tidak tersedia atau telah dipindahkan ke rute yang baru.
            </p>

            <!-- Navigation Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" id="btn-back-home" class="bg-brand-blue hover:bg-brand-blue-dark text-white px-8 py-3.5 rounded-full font-semibold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                
                <button onclick="history.back()" id="btn-go-back" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-8 py-3.5 rounded-full font-semibold transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Halaman Sebelumnya
                </button>
            </div>
        </div>

        <!-- Footer Copyright inside 404 page -->
        <p class="text-gray-400 text-sm mt-12">
            &copy; {{ date('Y') }} Lokachara Travel. Hak cipta dilindungi.
        </p>
    </div>
</body>

</html>
