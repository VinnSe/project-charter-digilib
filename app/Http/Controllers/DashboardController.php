<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Detail_Borrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil info pengguna yang sedang login
        $userLogin = Auth::user();
        $isAdmin = $userLogin?->role === 'admin';
        $kodeUser = $userLogin?->code;

        // Total Buku yang Sedang Dipinjam
        if ($isAdmin) {
            // Admin → lihat keseluruhan
            $pinjamBuku = Book::query()->select('being_borrowed')->get();
            $totalPinjam = 0;
            foreach ($pinjamBuku as $item) {
                $totalPinjam += $item->being_borrowed;
            }

            // Buku populer → semua data (sudah hapus 'price')
            $populer = Book::query()
                ->join('detail_borrows', 'books.code', '=', 'detail_borrows.code_book')
                ->selectRaw('title, count(detail_borrows.code_book) as total')
                ->groupBy('title')
                ->orderBy('total', 'desc')
                ->get();
        } else {
            // User biasa → hanya hitung miliknya sendiri
            $totalPinjam = 0;
            $populer = collect();
            
            if ($kodeUser) {
                // Ambil semua kode peminjaman milik user ini
                $kodePinjaman = Borrow::where('code_user', $kodeUser)->pluck('code');
                
                // Hitung jumlah buku yang dipinjam user ini
                $totalPinjam = Detail_Borrow::whereIn('code_borrow', $kodePinjaman)->count();
                
                // Buku yang sering dipinjam OLEH USER INI SAJA (sudah hapus 'price')
                $populer = Detail_Borrow::whereIn('code_borrow', $kodePinjaman)
                    ->join('books', 'detail_borrows.code_book', '=', 'books.code')
                    ->selectRaw('books.title, count(detail_borrows.code_book) as total')
                    ->groupBy('books.title')
                    ->orderBy('total', 'desc')
                    ->get();
            }
        }

        return view('dashboard', compact(
            'totalPinjam',
            'populer'
        ));
    }
}