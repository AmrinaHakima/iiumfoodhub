@extends('layouts.app')

@section('content')
<style>
    :root { 
        --primary-teal: #008080; 
        --bg-gray: #f8fafc;
    }
    
    body { background-color: var(--bg-gray); }
    .receipt-dashed { border-bottom: 2px dashed #e2e8f0; }
    .confirm-btn { background-color: #111827; transition: all 0.2s; }

    .method-card {
        border: 2px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.3s;
    }

    .method-card.active {
        border-color: #008080;
        background-color: #f0fdfa;
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
            
            <div id="checkout-items-list" class="space-y-4 mb-6"></div>

            <div class="receipt-dashed mb-6"></div>

            <div class="space-y-3">
                <div class="flex justify-between text-gray-600 text-sm">
                    <span>Subtotal</span>
                    <span id="subtotal-amount">RM 0.00</span>
                </div>
                <div class="flex justify-between text-gray-600 text-sm">
                    <span id="fee-label">Service Fee (Pickup)</span>
                    <span id="service-fee">RM 0.50</span>
                </div>
                <div class="flex justify-between text-xl font-black text-gray-900 pt-2">
                    <span>Total</span>
                    <span class="text-teal-600" id="final-total">RM 0.00</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4 ml-2">Delivery Method</h2>
            <div class="grid grid-cols-2 gap-4">
                <div onclick="setMethod('Self pickup')" id="method-pickup" class="method-card active bg-white p-4 rounded-2xl text-center">
                    <i class="fa-solid fa-person-walking text-2xl mb-2 text-teal-600"></i>
                    <p class="font-bold text-gray-800 text-sm">Self Pickup</p>
                    <p class="text-[10px] text-gray-400">Fee: RM 0.50</p>
                </div>
                <div onclick="setMethod('Delivery')" id="method-delivery" class="method-card bg-white p-4 rounded-2xl text-center">
                    <i class="fa-solid fa-motorcycle text-2xl mb-2 text-gray-400"></i>
                    <p class="font-bold text-gray-800 text-sm">Delivery</p>
                    <p class="text-[10px] text-gray-400">Fee: RM 1.00</p>
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
                    <p class="font-bold text-gray-800">Online Bank In</p>
                    <p class="text-[10px] text-teal-600 font-bold uppercase">Ready to pay</p>
                </div>
                <i class="fa-solid fa-circle-check ml-auto text-teal-600 text-xl"></i>
            </div>
        </div>

        <button onclick="placeOrder()" class="confirm-btn w-full text-white py-4 rounded-2xl font-bold text-lg shadow-xl mb-4">
            Place Order Now
        </button>
    </div>
</div>

<script>
    let selectedMethod = 'Self pickup';
    let cartSubtotal = 0;

    function setMethod(method) {
        selectedMethod = method;
        
        const pickupCard = document.getElementById('method-pickup');
        const deliveryCard = document.getElementById('method-delivery');
        const feeLabel = document.getElementById('fee-label');
        const feeAmountEl = document.getElementById('service-fee');
        
        let currentFee = (method === 'Self pickup') ? 0.50 : 1.00;

        if (method === 'Self pickup') {
            pickupCard.classList.add('active', 'border-teal-600', 'bg-teal-50');
            pickupCard.querySelector('i').classList.replace('text-gray-400', 'text-teal-600');
            deliveryCard.classList.remove('active', 'border-teal-600', 'bg-teal-50');
            deliveryCard.querySelector('i').classList.replace('text-teal-600', 'text-gray-400');
            feeLabel.innerText = "Service Fee (Pickup)";
        } else {
            deliveryCard.classList.add('active', 'border-teal-600', 'bg-teal-50');
            deliveryCard.querySelector('i').classList.replace('text-gray-400', 'text-teal-600');
            pickupCard.classList.remove('active', 'border-teal-600', 'bg-teal-50');
            pickupCard.querySelector('i').classList.replace('text-teal-600', 'text-gray-400');
            feeLabel.innerText = "Delivery Fee";
        }

        feeAmountEl.innerText = `RM ${currentFee.toFixed(2)}`;
        updateTotal(currentFee);
    }

    function loadCheckout() {
        const cart = JSON.parse(localStorage.getItem('foodhub_cart')) || [];
        const container = document.getElementById('checkout-items-list');
        const subtotalEl = document.getElementById('subtotal-amount');

        if (cart.length === 0) {
            container.innerHTML = `<p class="text-gray-400 text-center py-4">Your basket is empty</p>`;
            return;
        }

        cartSubtotal = 0;
        container.innerHTML = ''; 

        cart.forEach((item) => {
            cartSubtotal += item.price;
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

        subtotalEl.innerText = `RM ${cartSubtotal.toFixed(2)}`;
        setMethod('Self pickup'); // Initialize with default fee
    }

    function updateTotal(fee) {
        const totalEl = document.getElementById('final-total');
        const finalTotal = cartSubtotal + fee;
        totalEl.innerText = `RM ${finalTotal.toFixed(2)}`;
    }

    function clearCart() {
        localStorage.removeItem('foodhub_cart');
        window.location.reload();
    }

    function placeOrder() {
        localStorage.setItem('foodhub_delivery_method', selectedMethod);
        window.location.href = "{{ url('/order') }}"; 
    }

    loadCheckout();
</script>
@endsection