<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cafe;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    // --- AUTHENTICATION ---

    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('foodhub');
    }

    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/foodhub');
        }

        return back()->withErrors(['email' => 'Invalid Credentials']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // --- FOOD HUB LOGIC ---

    // Screen 1: Select a Cafe
    public function index() {
        $cafes = Cafe::all();
        $now = Carbon::now('Asia/Kuala_Lumpur');

        foreach ($cafes as $cafe) {
            // Convert DB strings (08:00:00) to Carbon instances for comparison
            $open = Carbon::createFromFormat('H:i:s', $cafe->open_time);
            $close = Carbon::createFromFormat('H:i:s', $cafe->close_time);
            
            // Determine if current time is between open and close
            $cafe->is_open = $now->between($open, $close);
        }

        return view('foodhub', compact('cafes'));
    }

    // Screen 2: Show Menu
    public function showMenu($id) {
        $cafe = Cafe::findOrFail($id);
        $foods = MenuItem::where('cafe_id', $id)->where('category', 'Food')->get();
        $drinks = MenuItem::where('cafe_id', $id)->where('category', 'Drinks')->get();

        return view('menu', compact('cafe', 'foods', 'drinks'));
    }

    // Screen 3-5: Process Order
    public function placeOrder(Request $request) {
        $request->validate([
            'cafe_id' => 'required',
            'total_amount' => 'required',
            'delivery_method' => 'required',
            'payment_method' => 'required',
        ]);

        // Generate ID like: F0000243251
        $orderNumber = 'F' . str_pad(mt_rand(1, 99999999), 9, '0', STR_PAD_LEFT);

        $order = new Order();
        $order->order_id = $orderNumber;
        $order->user_id = Auth::id();
        $order->cafe_id = $request->cafe_id;
        $order->total_amount = $request->total_amount;
        $order->delivery_method = $request->delivery_method;
        $order->payment_method = $request->payment_method;
        $order->save();

        return redirect()->route('order.success', $order->id);
    }

    // Screen 6: Order Confirmed
    public function orderSuccess($id) {
        $order = Order::with('cafe')->findOrFail($id);
        return view('order_confirmed', compact('order'));
    }
}