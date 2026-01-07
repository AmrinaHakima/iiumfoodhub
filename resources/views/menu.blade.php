@extends('layouts.app')
@section('content')
<style>
    :root { 
        --primary-teal: #008080; 
        --dark-teal: #006666; 
    }
    
    body {
        background-color: #f4f7f6;
    }

    .header-gradient { 
        background: linear-gradient(135deg, var(--primary-teal), #4db6ac); 
    }

    .category-pill { 
        transition: all 0.2s; 
        cursor: pointer; 
        border: 1px solid var(--primary-teal);
        background-color: white;
        color: var(--primary-teal);
    }
    
    .category-pill.active { 
        background-color: var(--primary-teal); 
        color: white; 
    }

    .food-img { 
        height: 100px; 
        width: 100px; 
        object-fit: cover; 
        border-radius: 1rem; 
    }

    .item-hidden { 
        display: none !important; 
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

<div class="min-h-screen pb-32">
    <div class="header-gradient text-white px-6 py-6 shadow-md flex items-center rounded-b-3xl">
        <a href="{{ url('/') }}" class="mr-4 hover:opacity-80 transition">
            <i class="fa-solid fa-chevron-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold">{{ $cafe->name }}</h1>
            <p class="text-xs opacity-80">Catalog Menu</p>
        </div>
    </div>

    <div class="flex overflow-x-auto px-6 py-4 gap-2 no-scrollbar">
        <span onclick="filterByCategory('all', this)" class="category-pill active px-5 py-2 rounded-full text-sm font-bold whitespace-nowrap shadow-sm">
            All Items
        </span>
        <span onclick="filterByCategory('Food', this)" class="category-pill px-5 py-2 rounded-full text-sm font-bold whitespace-nowrap shadow-sm">
            Food
        </span>
        <span onclick="filterByCategory('Drinks', this)" class="category-pill px-5 py-2 rounded-full text-sm font-bold whitespace-nowrap shadow-sm">
            Drinks
        </span>
    </div>

    <div class="px-6">
        <div class="grid grid-cols-1 gap-4" id="menu-list">
            @forelse($cafe->menuItems as $item)
                <div class="menu-card bg-white p-4 rounded-2xl shadow-sm flex items-center border border-gray-100" data-type="{{ $item->category }}">
                    <div class="flex-1 pr-3">
                        <div class="flex items-center mb-1">
                            <span class="text-[10px] uppercase tracking-widest text-teal-600 font-extrabold">{{ $item->category }}</span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-base">{{ $item->name }}</h3>
                        <p class="text-gray-500 text-xs line-clamp-2 mt-1">{{ $item->description }}</p>                       
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">RM {{ number_format($item->price, 2) }}</span>
                            <button 
                                onclick="addToBasket('{{ $item->name }}', {{ $item->price }})"
                                class="bg-teal-50 text-teal-700 font-bold px-4 py-1.5 rounded-xl hover:bg-teal-600 hover:text-white transition active:scale-95 text-sm">
                                + Add
                            </button>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" class="food-img shadow-sm border border-gray-50">
                        @else
                            <div class="food-img bg-gray-100 flex items-center justify-center text-gray-300">
                                <i class="fa-solid fa-utensils text-2xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <p class="text-gray-400 font-medium">No items available yet for this cafe.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="fixed bottom-6 left-6 right-6 bg-gray-900 text-white p-4 rounded-3xl shadow-2xl flex justify-between items-center z-50">
        <div class="flex items-center">
            <div class="bg-teal-500 p-2.5 rounded-xl mr-3 relative">
                <i class="fa-solid fa-basket-shopping text-lg"></i>
                <span id="basket-count" class="absolute -top-1 -right-1 bg-white text-gray-900 text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center hidden">0</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider opacity-60 font-bold">Total Order</p>
                <p class="font-bold text-teal-400" id="display-total">RM 0.00</p>
            </div>
        </div>
        
        <a href="{{ route('checkout') }}" class="bg-white text-gray-900 px-6 py-2.5 rounded-2xl font-bold text-sm hover:bg-gray-100 transition shadow-lg">
            Checkout Now
        </a>
    </div>
</div>

<script>
    let basket = JSON.parse(localStorage.getItem('foodhub_cart')) || [];
    updateBasketUI();

    function addToBasket(name, price) {
        basket.push({ name: name, price: parseFloat(price) });
        localStorage.setItem('foodhub_cart', JSON.stringify(basket));
        updateBasketUI();
    }

    function updateBasketUI() {
        const totalDisplay = document.getElementById('display-total');
        const countDisplay = document.getElementById('basket-count');
        let total = basket.reduce((sum, item) => sum + item.price, 0);
        totalDisplay.innerText = "RM " + total.toFixed(2);
        if (basket.length > 0) {
            countDisplay.innerText = basket.length;
            countDisplay.classList.remove('hidden');
        } else {
            countDisplay.classList.add('hidden');
        }
    }

    function filterByCategory(category, pillElement) {
        document.querySelectorAll('.category-pill').forEach(el => el.classList.remove('active'));
        pillElement.classList.add('active');
        document.querySelectorAll('.menu-card').forEach(card => {
            const itemType = card.getAttribute('data-type');
            card.classList.toggle('item-hidden', category !== 'all' && itemType !== category);
        });
    }
</script>
@endsection