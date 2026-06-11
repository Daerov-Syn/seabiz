<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SeaBiz')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#1d9bf0',
                            dark: '#102a43',
                            muted: '#5b6c89'
                        }
                    }
                }
            }
        }
    </script>

    @yield('styles')
</head>
<body class="font-inter min-h-screen text-slate-800 m-0">

@yield('content')

@yield('scripts')
</body>
</html>
