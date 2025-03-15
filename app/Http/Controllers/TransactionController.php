<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        $members = Member::all(); // Tambahkan ini untuk menampilkan data member di form
        return view('transactions.create', compact('products', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'total_harga' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah stok cukup sebelum menyimpan transaksi
            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);
                if ($productModel->stok < $product['quantity']) {
                    return redirect()->back()->with('error', "Stok {$productModel->nama_produk} tidak mencukupi!");
                }
            }

            $nomor_transaksi = 'TRX-' . date('Ymd') . '-' . mt_rand(10000, 99999);
            $totalHarga = $request->total_harga;
            $diskon = $request->member_id ? 0.05 * $totalHarga : 0;
            $totalHargaSetelahDiskon = $totalHarga - $diskon;

            $transaction = Transaction::create([
                'nomor_transaksi' => $nomor_transaksi,
                'tanggal_transaksi' => now(),
                'total_harga' => $totalHarga,
                'diskon' => $diskon,
                'total_harga_setelah_diskon' => $totalHargaSetelahDiskon,
                'total_bayar' => $request->total_bayar,
                'kembalian' => $request->kembalian,
                'member_id' => $request->member_id,
            ]);

            \Log::info('Data produk yang diterima:', $request->products);
            
            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);
                $productModel->stok -= $product['quantity'];
                $productModel->save();

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'harga' => $productModel->harga,
                ]);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            $transaction->delete();
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with('member')->find($id);
        
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaksi tidak ditemukan');
        }

        return view('transactions.show', compact('transaction'));
    }
}