<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CafeController extends Controller
{
    public function index()
{
    $cafes = \App\Models\Cafe::all();
    return view('foodhub', compact('cafes')); 
}

    public function show($id)
    {
        $cafe = Cafe::with('menuItems')->findOrFail($id);
        return view('menu', compact('cafe'));
    }

}