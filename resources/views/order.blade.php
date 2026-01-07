@extends('layouts.app')

@section('content')
<style>
    .success-check {
        background: #008080;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 20px rgba(0, 128, 128, 0.2);
    }

    .order-card {
        background: white;
        border-radius: 2rem;
        position: relative;
    }

    /* Receipt jagged edge effect */
    .order-card::after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(-45deg, #f4f7f6 10px, transparent 0), 
                    linear-gradient(45deg, #f4f7f6 10px, transparent 0);
        background-size: 20px 20px;
    }
</style>

<div class="min-h-screen bg-[#f4f7f6] px-6 flex flex-col items-center justify-center pb-20">
    
    <div class="success-check mb-6 animate-bounce">
        <i class="fa-solid fa-check text-4xl text-white"></i>
    </div>

    <div class="text-center mb-8">
        <h1 class="text-2xl font-black text-gray-800">Order Confirmed!</h1>
        <p class="text-gray-500 text-sm">Your order has been sent to the cafe.</p>
    </div>

    <div class="order-card w-full max-w-md p-8 shadow-sm mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order ID</p>
                <p class="font-bold text-gray-800">#{{ strtoupper(substr(uniqid(), 7)) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</p>
                <p class="font-bold text-gray-800">{{ now()->format('d M, h:i A') }}</p>
            </div>
        </div>

        <div class="border-t border-dashed border-gray-100 my-4"></div>

        <div class="space-y-4 mb-6">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Payment Method</span>
                <span class="font-bold text-gray-800">Cash on Delivery</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Status</span>
                <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Preparing</span>
            </div>
        </div>

        <div class="border-t-2 border-gray-50 pt-4 flex justify-between items-center">
            <span class="font-bold text-gray-400 text-sm uppercase">Amount Paid</span>
            <span class="text-2xl font-black text-teal-600" id="final-amount">RM 0.00</span>
        </div>
    </div>

    <div class="w-full max-w-md space-y-4">
        <a href="{{ url('/') }}" class="block w-full bg-gray-900 text-white text-center py-4 rounded-2xl font-bold shadow-xl hover:bg-gray-800 transition">
            Back to Home
        </a>
        <button onclick="window.print()" class="block w-full bg-white text-gray-500 text-center py-4 rounded-2xl font-bold border border-gray-200 hover:bg-gray-50 transition text-sm">
            <i class="fa-solid fa-download mr-2"></i> Save Receipt
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Get the final price from LocalStorage (saved during checkout)
        const cart = JSON.parse(localStorage.getItem('foodhub_cart')) || [];
        let subtotal = 0;
        cart.forEach(item => subtotal += item.price);
        
        // Add service fee (RM 0.50)
        const total = subtotal > 0 ? subtotal + 0.50 : 0;
        
        document.getElementById('final-amount').innerText = "RM " + total.toFixed(2);

        // 2. Clear the cart since the order is finished!
        localStorage.removeItem('foodhub_cart');
    });
</script>
@endsection