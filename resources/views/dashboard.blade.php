@extends('layouts.app')

@section('title', 'SISKA Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Today | September 20')

@section('content')
<!-- Stats Grid - Hanya 2 Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Card 1 - Total Shipping Instruction Documents -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Total Shipping Instruction</p>
                <p class="text-3xl font-bold">156</p>
                <p class="text-blue-100 text-xs mt-1">Documents</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 - Active Ships -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Active Ships</p>
                <p class="text-3xl font-bold">24</p>
                <p class="text-green-100 text-xs mt-1">Currently Operating</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-ship text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Documents Table -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Recent Documents</h3>
        <p class="text-sm text-gray-500 mt-1">Latest shipping instruction documents created</p>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">SI-KSS-001/VIII/2025</p>
                        <p class="text-xs text-gray-500">To: PT BERLIAN LINTAS TAMA</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span>
                    <p class="text-xs text-gray-400 mt-1">2 mins ago</p>
                </div>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">SI-KSS-002/VIII/2025</p>
                        <p class="text-xs text-gray-500">To: PT SARANA MARITIM INDONESIA</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Processing</span>
                    <p class="text-xs text-gray-400 mt-1">15 mins ago</p>
                </div>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">SI-KSS-003/VIII/2025</p>
                        <p class="text-xs text-gray-500">To: PT PELAYARAN NASIONAL</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span>
                    <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                </div>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">SI-KSS-004/VIII/2025</p>
                        <p class="text-xs text-gray-500">To: PT BORNEO SHIPPING</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Revision</span>
                    <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                </div>
            </div>

            <div class="flex items-center justify-between py-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">SI-KSS-005/VIII/2025</p>
                        <p class="text-xs text-gray-500">To: PT MEGA CARGO LINES</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completed</span>
                    <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <a href="/shipping-instruction" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All Documents →
            </a>
        </div>
    </div>
</div>
@endsection