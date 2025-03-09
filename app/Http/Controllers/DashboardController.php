<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();

        return view('dashboard', compact('totalProducts', 'totalTransactions'));
    }
}
