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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        
        <!-- Custom CSS for buttons -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        
        <!-- Inline styles for improved UI -->
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8fafc;
                color: #1e293b;
            }
            
            .dashboard-container {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                min-height: 100vh;
            }
            
            .header-section {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                border-bottom: none;
            }
            
            .header-content {
                color: #fff;
                font-weight: 600;
            }
            
            .header-content h2 {
                font-size: 1.5rem;
                font-weight: 700;
                letter-spacing: 0.5px;
                text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            }
            
            .content-section {
                padding: 2rem 0;
            }
            
            /* Table Styling */
            table {
                box-shadow: 0 4px 6px rgba(0,0,0,0.03);
                border-radius: 10px;
                overflow: hidden;
                border: 1px solid #f1f5f9;
            }
            
            table thead tr {
                background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
                color: white;
            }
            
            table thead th {
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
                padding: 14px 16px;
            }
            
            table tbody tr {
                border-bottom: 1px solid #f1f5f9;
            }
            
            table tbody tr:last-child {
                border-bottom: none;
            }
            
            table tbody td {
                padding: 14px 16px;
            }
            
            table tbody tr:nth-child(odd) {
                background-color: #ffffff;
            }
            
            table tbody tr:nth-child(even) {
                background-color: #f9fafb;
            }
            
            table tbody tr:hover {
                background-color: #f0f9ff;
                transition: background-color 0.2s ease;
            }
            
            /* Dashboard Card Styling */
            .dashboard-card {
                border-radius: 12px;
                overflow: hidden;
                background: #ffffff;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid rgba(0,0,0,0.03);
            }
            
            .dashboard-card.gradient {
                border: none;
            }
            
            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 25px rgba(0,0,0,0.08);
            }
            
            .dashboard-card h4 {
                font-weight: 700;
                font-size: 1.1rem;
            }
            
            .dashboard-card p {
                font-size: 2rem;
                font-weight: 700;
            }
            
            /* Button Styling */
            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                border: none;
                padding: 0.65rem 1.5rem;
                border-radius: 8px;
                font-weight: 600;
                color: white;
                box-shadow: 0 4px 6px rgba(37, 99, 235, 0.25);
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
            }
            
            .btn-danger {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                border: none;
                padding: 0.65rem 1.5rem;
                border-radius: 8px;
                font-weight: 600;
                color: white;
                box-shadow: 0 4px 6px rgba(220, 38, 38, 0.25);
                transition: all 0.3s ease;
            }
            
            .btn-danger:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 15px rgba(220, 38, 38, 0.3);
            }
            
            /* Action Button Styling */
            table tr td:last-child a, 
            table tr td:last-child button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.85rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.08);
                transition: all 0.2s ease;
                margin: 0.25rem;
                text-decoration: none;
            }
            
            table tr td:last-child a:hover, 
            table tr td:last-child button:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0,0,0,0.12);
            }
            
            table a.edit-btn, 
            table a[href*="edit"] {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
                color: white !important;
            }
            
            table button.delete-btn, 
            table a[href*="delete"], 
            table a[href*="hapus"] {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
                color: white !important;
            }
            
            /* Form Styling */
            .form-control {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                padding: 0.75rem 1rem;
                background-color: #ffffff;
                box-shadow: 0 1px 2px rgba(0,0,0,0.03);
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
            }
            
            label {
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.5rem;
                display: block;
            }
            
            /* Custom Navigation Styles */
            .custom-nav-link {
                padding: 0.75rem 1.25rem;
                border-radius: 8px;
                font-weight: 600;
                display: flex;
                align-items: center;
                transition: all 0.2s ease;
                color: #1e293b;
            }
            
            .custom-nav-link:hover {
                background-color: rgba(59, 130, 246, 0.08);
                color: #3b82f6;
            }
            
            .custom-nav-link.active {
                background-color: rgba(59, 130, 246, 0.1);
                color: #3b82f6;
            }
            
            .custom-nav-link svg {
                width: 18px;
                height: 18px;
                margin-right: 8px;
            }

            /* Card Stats with gradient backgrounds */
            .card-blue {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
                position: relative;
            }
            
            .card-green {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                position: relative;
            }
            
            .card-amber {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                color: white;
                position: relative;
            }
            
            .card-indigo {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: white;
                position: relative;
            }
            
            .card-rose {
                background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
                color: white;
                position: relative;
            }
            
            /* Make stat card icons visible */
            .card-icon {
                position: absolute;
                top: 1rem;
                right: 1rem;
                width: 2.5rem;
                height: 2.5rem;
                background-color: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }
            
            /* Status badges */
            .badge {
                padding: 0.25em 0.65em;
                font-size: 0.85em;
                font-weight: 600;
                border-radius: 9999px;
                display: inline-flex;
                align-items: center;
            }
            
            .badge:before {
                content: '';
                display: block;
                width: 0.5em;
                height: 0.5em;
                border-radius: 50%;
                margin-right: 0.5em;
            }
            
            .badge-success {
                background-color: #dcfce7;
                color: #166534;
            }
            
            .badge-success:before {
                background-color: #16a34a;
            }
            
            .badge-warning {
                background-color: #fef9c3;
                color: #854d0e;
            }
            
            .badge-warning:before {
                background-color: #ca8a04;
            }
            
            .badge-danger {
                background-color: #fee2e2;
                color: #991b1b;
            }
            
            .badge-danger:before {
                background-color: #dc2626;
            }

            /* Improve sidebar menu visibility */
            .dashboard-btn, .post-berita-btn, a[href="#"] {
                color: #1e293b !important;
                font-weight: 500;
            }
            
            .dashboard-btn.active, .post-berita-btn.active {
                background-color: #dbeafe;
                color: #2563eb !important;
                font-weight: 600;
            }
            
            /* Fix user profile dropdown */
            .profile-menu-trigger {
                display: inline-flex;
                align-items: center;
                padding: 0.4rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                background-color: white;
                font-size: 0.875rem;
                font-weight: 500;
                color: #374151;
                transition: all 0.2s;
            }
            
            .profile-menu-trigger:hover {
                background-color: #f9fafb;
                color: #111827;
            }
            
            .profile-avatar {
                height: 1.75rem;
                width: 1.75rem;
                border-radius: 9999px;
                margin-right: 0.5rem;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="dashboard-container">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="header-section shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="header-content">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="content-section">
                {{ $slot }}
            </main>
        </div>
        
        <!-- Add reference to custom JavaScript -->
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
