<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;


class ReportController extends Controller
{
    public function index(Request $request)
    {
    $tanggal = $request->input('tanggal', date('Y-m-d')); // Default ke hari ini

    // Ambil transaksi berdasarkan tanggal
    $transactions = Transaction::whereDate('tanggal_transaksi', $tanggal)->get();

    // Hitung total pemasukan berdasarkan transaksi di tanggal tersebut
    $total_pemasukan = $transactions->sum('total_harga');

    return view('reports.index', compact('transactions', 'tanggal', 'total_pemasukan'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $tanggal = $request->tanggal;

        $transactions = Transaction::whereDate('tanggal_transaksi', $tanggal)->get();
        $total_pemasukan = $transactions->sum('total_harga_setelah_diskon');

        return view('reports.index', compact('transactions', 'total_pemasukan', 'tanggal'));
    }
}
