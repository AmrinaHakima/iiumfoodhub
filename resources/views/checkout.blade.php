@extends('layouts.app')

@section('content')
<style>
    :root { 
        --primary-teal: #008080; 
        --bg-gray: #f8fafc;
    }
    
    body { 
        background-color: var(--bg-gray); 
    }

    .receipt-dashed { 
        border-bottom: 2px dashed #e2e8f0; 
    }

    .confirm-btn {
        background-color: #111827;
        transition: all 0.2s;
    }

    .confirm-btn:active {
        transform: scale(0.98);
    }
</style>

<div class="min-h-screen pb-10">
    <div class="bg-white px-6 py-6 shadow-sm flex items-center mb-6">
        <a href="javascript:history.back()" class="mr-4 text-gray-600 hover:text-teal-600 transition">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Checkout Order</h1>
    </div>

    <div class="px-6">
        <div class="bg-white rounded-3xl p-6 shadow-sm mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Your Items</h2>
                <button onclick="clearCart()" class="text-xs text-red-500 font-bold">Clear All</button>
            </div>
            
            <div id="checkout-items-list" class="space-y-4 mb-6">
                </div>

            <div class="receipt-dashed mb-6"></div>

            <div class="space-y-3">
                <div class="flex justify-between text-gray-600 text-sm">
                    <span>Subtotal</span>
                    <span id="subtotal-amount">RM 0.00</span>
                </div>
                <div class="flex justify-between text-gray-600 text-sm">
                    <span>Service Fee</span>
                    <span id="service-fee">RM 0.50</span>
                </div>
                <div class="flex justify-between text-xl font-black text-gray-900 pt-2">
                    <span>Total</span>
                    <span class="text-teal-600" id="final-total">RM 0.00</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm mb-8 border-2 border-teal-600/20">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Method</h2>
            <div class="flex items-center p-4 border-2 border-teal-600 rounded-2xl bg-teal-50">
                <div class="bg-teal-600 text-white p-2 rounded-lg mr-4">
                    <i class="fa-solid fa-wallet text-lg"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">Cash on Delivery</p>
                    <p class="text-[10px] text-teal-600 font-bold uppercase">Pay at counter</p>
                </div>
                <i class="fa-solid fa-circle-check ml-auto text-teal-600 text-xl"></i>
            </div>
        </div>

        <button onclick="placeOrder()" class="confirm-btn w-full text-white py-4 rounded-2xl font-bold text-lg shadow-xl mb-4">
            Place Order Now
        </button>
        
        <p class="text-center text-gray-400 text-xs">By clicking place order, you agree to the IIUMFoodHub terms.</p>
    </div>
</div>

<script>
    function loadCheckout() {
        const cart = JSON.parse(localStorage.getItem('foodhub_cart')) || [];
        const container = document.getElementById('checkout-items-list');
        const subtotalEl = document.getElementById('subtotal-amount');
        const totalEl = document.getElementById('final-total');
        const serviceFee = 0.50;

        if (cart.length === 0) {
            container.innerHTML = `<p class="text-gray-400 text-center py-4">Your basket is empty</p>`;
            return;
        }

        let subtotal = 0;
        container.innerHTML = ''; // Clear existing

        cart.forEach((item, index) => {
            subtotal += item.price;
            container.innerHTML += `
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-bold text-gray-800">${item.name}</p>
                        <p class="text-[10px] text-gray-400">Standard Portion</p>
                    </div>
                    <span class="font-bold text-gray-800">RM ${item.price.toFixed(2)}</span>
                </div>
            `;
        });

        subtotalEl.innerText = `RM ${subtotal.toFixed(2)}`;
        totalEl.innerText = `RM ${(subtotal + serviceFee).toFixed(2)}`;
    }

    function clearCart() {
        localStorage.removeItem('foodhub_cart');
        window.location.reload();
    }

    function placeOrder() {
    window.location.href = "{{ url('/order') }}"; 
}

    // Initialize the page
    loadCheckout();
</script>
@endsection