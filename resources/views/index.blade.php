@extends('layouts.app')

@section('content')
<style>
    :root { --primary-teal: #008080; --dark-teal: #006666; }
    body { background-color: #f4f7f6; }
    .cafe-card { transition: transform 0.2s ease; border-left: 5px solid transparent; }
    .cafe-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 128, 128, 0.1); }
    .cafe-card.is-open { border-left-color: var(--primary-teal); }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
    .badge-open { background-color: #e8f5e9; color: #2e7d32; }
    .badge-closed { background-color: #ffebee; color: #c62828; }
    .header-gradient { background: linear-gradient(135deg, var(--primary-teal), #4db6ac); }
</style>

<div class="min-h-screen">
    <div class="header-gradient text-white px-6 py-6 shadow-lg flex justify-between items-center rounded-b-3xl">
        <div>
            <h1 class="text-xl font-bold tracking-tight">IIUMFoodHub</h1>
            <p class="text-xs opacity-80">Satisfy your cravings</p>
        </div>
        <div class="bg-white/20 p-3 rounded-full"><i class="fa-solid fa-cart-shopping"></i></div>
    </div>

    <div class="px-6 py-8">
        <h2 class="text-gray-800 font-bold text-2xl mb-6">Select a Cafe</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($cafes as $cafe)
                @php
                    $isOpen = now()->format('H:i:s') >= $cafe->open_time && now()->format('H:i:s') <= $cafe->close_time;
                    $isHalimah = (trim($cafe->name) === 'Cafe Halimah');
                @endphp

                <div class="cafe-card bg-white rounded-2xl shadow-sm p-5 {{ $isOpen ? 'is-open' : 'opacity-75' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $cafe->name }}</h3>
                            <p class="text-gray-400 text-xs"><i class="fa-solid fa-location-dot mr-1"></i>{{ $cafe->location }}</p>
                            @if($isHalimah)
                                <p class="text-teal-600 text-xs mt-1 font-bold italic">Mahallah Halimatus Saadiah</p>
                            @endif
                        </div>
                        <span class="status-badge {{ $isOpen ? 'badge-open' : 'badge-closed' }}">
                            {{ $isOpen ? '● Open' : '● Closed' }}
                        </span>
                        @if($isHalimah)
                            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=100&q=80" class="w-16 h-16 rounded-lg ml-3 object-cover">
                        @endif
                    </div>

                    <hr class="my-3 border-gray-100">

                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 font-medium italic">
                            {{ date('h:i A', strtotime($cafe->open_time)) }} - {{ date('h:i A', strtotime($cafe->close_time)) }}
                        </span>
                        <a href="{{ url('/cafe/'.$cafe->id) }}" class="bg-teal-600 text-white text-xs px-4 py-2 rounded-lg font-bold">
                            View Menu
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection