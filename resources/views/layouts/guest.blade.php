<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal Berita') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
            
            .bg-gradient-custom {
                background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            }
            
            .login-input {
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                padding: 16px 16px;
                padding-left: 45px;
                border-radius: 10px;
                width: 100%;
                font-size: 15px;
                transition: all 0.3s ease;
                margin-bottom: 5px;
                height: 55px;
            }
            
            .login-input:focus {
                background-color: #fff;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
                border-color: #6366f1;
                outline: none;
            }
            
            .input-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #6366f1;
                font-size: 16px;
            }
            
            .input-container {
                position: relative;
                margin-bottom: 20px;
            }
            
            .btn-login {
                background: #6366f1;
                color: white;
                border: none;
                padding: 15px;
                border-radius: 10px;
                font-weight: 600;
                font-size: 16px;
                width: 100%;
                height: 55px;
                transition: all 0.3s ease;
                cursor: pointer;
                margin-top: 10px;
            }
            
            .btn-login:hover {
                background: #4f46e5;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
            }
            
            .auth-card {
                background-color: white;
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                padding: 40px;
                width: 100%;
                max-width: 450px;
                margin-top: 20px;
            }
            
            input[type="checkbox"] {
                width: 18px;
                height: 18px;
                border-color: #6366f1;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-custom py-12 px-4 sm:px-6 lg:px-8">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
