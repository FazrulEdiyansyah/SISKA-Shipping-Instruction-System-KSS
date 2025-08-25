<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SISKA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-56 bg-white shadow-lg flex-shrink-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-7 h-7 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-ship text-white text-sm"></i>
                    </div>
                    <h1 class="text-lg font-bold text-gray-800">SISKA</h1>
                </div>
            </div>
            
            <nav class="mt-4">
                <div class="px-4 mb-2">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">MENU</span>
                </div>
                
                <a href="/" class="flex items-center px-4 py-2.5 {{ request()->is('/') ? 'text-blue-600 bg-blue-50 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-home w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                
                <a href="/shipping-instruction" class="flex items-center px-4 py-2.5 {{ request()->is('shipping-instruction') ? 'text-blue-600 bg-blue-50 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-file-alt w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Shipping Instruction</span>
                </a>
                
                <a href="/shipping-instruction-overview" class="flex items-center px-4 py-2.5 {{ request()->is('shipping-instruction-overview*') ? 'text-blue-600 bg-blue-50 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-table w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">SI Overview</span>
                </a>
                
                
                <a href="/ship-vendor-management" class="flex items-center px-4 py-2.5 {{ request()->is('ship-vendor-management*') ? 'text-blue-600 bg-blue-50 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-anchor w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Ship Vendor Management</span>
                </a>
                
                <a href="/approval-management" class="flex items-center px-4 py-2.5 {{ request()->is('approval-management*') ? 'text-blue-600 bg-blue-50 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-signature w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Approval Management</span>
                </a>
                
                <a href="{{ route('report.index') }}" class="flex items-center px-4 py-2.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-chart-bar w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Reports</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-2.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-cog w-4 h-4 mr-2"></i>
                    <span class="font-medium text-sm">Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b flex-shrink-0">
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-600">@yield('page-subtitle', 'Today | September 20')</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content - Scrollable -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-5">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>