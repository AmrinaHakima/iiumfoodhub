@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-teal: #008080;
        --light-teal: #e0f2f1;
        --dark-teal: #006666;
    }

    body {
        background-color: #f4f7f6;
    }

    .cafe-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 5px solid transparent;
    }

    .cafe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 128, 128, 0.15);
    }

    .cafe-card.is-open {
        border-left-color: var(--primary-teal);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-open {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .badge-closed {
        background-color: #ffebee;
        color: #c62828;
    }

    .header-gradient {
        background: linear-gradient(135deg, var(--primary-teal), #4db6ac);
    }
</style>

<div class="min-h-screen">
    <div class="header-gradient text-white px-6 py-8 shadow-lg flex justify-start items-center rounded-b-[2.5rem]">
        <div>
            <h1 class="text-2xl font-black tracking-tight">IIUMFoodHub</h1>
            <p class="text-xs opacity-90 font-medium">Serving the Ummah's Cravings</p>
        </div>
    </div>

    <div class="px-6 py-8">
        <div class="mb-8">
            <h2 class="text-gray-900 font-extrabold text-2xl">Available Cafes</h2>
            <p class="text-sm text-gray-500 font-medium">Choose a Mahallah cafe to view the menu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($cafes as $cafe)
                @php
                    $currentTime = now()->format('H:i:s');
                    $isOpen = $currentTime >= $cafe->open_time && $currentTime <= $cafe->close_time;
                @endphp

                <div class="cafe-card bg-white rounded-3xl shadow-sm p-5 {{ $isOpen ? 'is-open' : 'opacity-75 grayscale-[20%]' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-xl text-gray-800">{{ $cafe->name }}</h3> 
                                    <div class="flex flex-col mt-2">
                                        <div class="flex items-center text-teal-600 text-xs font-bold uppercase tracking-wide">
                                            <i class="fa-solid fa-location-dot mr-1.5"></i>
                                            <span>{{ $cafe->location }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <span class="status-badge {{ $isOpen ? 'badge-open' : 'badge-closed' }}">
                                    {{ $isOpen ? '● Open' : '● Closed' }}
                                </span>
                            </div>
                        </div>

                        @if($cafe->image_url)
                        <div class="ml-4 flex-shrink-0">
                            <img src="{{ $cafe->image_url }}" 
                                 alt="{{ $cafe->name }}" 
                                 class="w-24 h-24 object-cover rounded-2xl shadow-md border-2 border-white">
                        </div>
                        @else
                        <div class="ml-4 w-24 h-24 bg-gray-100 flex items-center justify-center rounded-2xl text-gray-300">
                            <i class="fa-solid fa-utensils text-3xl"></i>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                        <div class="text-xs text-gray-500 font-semibold bg-gray-50 px-3 py-1.5 rounded-lg">
                            <i class="fa-regular fa-clock mr-1.5 text-teal-600"></i>
                            {{ date('h:i A', strtotime($cafe->open_time)) }} - {{ date('h:i A', strtotime($cafe->close_time)) }}
                        </div>
                        
                        <a href="{{ url('/cafe/'.$cafe->id) }}" 
                           class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-5 py-2.5 rounded-xl font-bold transition shadow-sm active:scale-95">
                            View Menu
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <i class="fa-solid fa-store-slash text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400 font-bold">No cafes found nearby.</p>
                    <p class="text-gray-400 text-xs mt-1">Please check your database seeder.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection