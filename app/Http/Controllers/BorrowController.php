<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Detail_Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Buat transaksi peminjaman baru
     * HANYA pengguna biasa yang boleh akses
     */
    public function index(Request $request)
    {
        $userLogin = Auth::user();
        
        // 🔒 Admin tidak boleh akses
        if ($userLogin?->role === 'admin') {
            abort(403, 'Halaman ini hanya untuk peminjam.');
        }
        
        if ($request->session()->has('code_borrow')) {
            return redirect('cart');
        }
        
        $opr = $userLogin->name;
        $tgl = date('dmY');
        $tgl_pinjam = Carbon::today();
        $jumlah = Borrow::where('operator', $opr)->count();
        $urutan = $jumlah + 1;
        $code_borrow = $tgl . "-" . $opr . "-" . $urutan;
        
        Borrow::create([
            'code'         => $code_borrow,
            'operator'     => $opr,
            'status'       => 0,
            'borrow_date' => $tgl_pinjam,
            'user_id'     => $userLogin->id,
            'code_user'   => $userLogin->code,
        ]);
        
        $request->session()->put('code_borrow', $code_borrow);
        return redirect('cart');
    }

    /**
     * Halaman Keranjang Peminjaman
     * HANYA pengguna biasa
     */
    public function cart(Request $request)
    {
        // 🔒 Admin tidak boleh akses
        if (Auth::user()?->role === 'admin') {
            abort(403, 'Halaman ini hanya untuk peminjam.');
        }
        
        $struk = $request->session()->get('code_borrow');
        if (!$struk) {
            return redirect('borrow')->with('message', 'Silakan mulai transaksi baru terlebih dahulu.');
        }
        
        $dataBuku = Book::all();
        $peminjam = Borrow::query()
            ->join('users', 'borrows.code_user', '=', 'users.code')
            ->select('users.name')
            ->where('borrows.code', $struk)
            ->first();
            
        $isi = Detail_Borrow::query()
            ->join('books', 'detail_borrows.code_book', '=', 'books.code')
            ->select('detail_borrows.code_book as code', 'books.title', 'detail_borrows.id')
            ->where('detail_borrows.code_borrow', $struk)
            ->get();
            
        return view('layouts.borrow.my-borrow', compact(
            'isi',
            'dataBuku',
            'peminjam'
        ));
    }

    /**
     * Tambah Buku ke Keranjang
     */
    public function addCart(Request $request)
    {
        // 🔒 Admin tidak boleh akses
        if (Auth::user()?->role === 'admin') {
            abort(403, 'Halaman ini hanya untuk peminjam.');
        }
        
        $struk = $request->session()->get('code_borrow');
        if (!$struk) {
            return redirect('borrow')->with('message', 'Mulai transaksi baru terlebih dahulu.');
        }
        
        $buku = Book::where('code', $request->code)->first();
        if (!$buku) {
            return redirect()->back()->with('message', 'Kode buku tidak ditemukan!');
        }
        
        $sudahAda = Detail_Borrow::where('code_borrow', $struk)
            ->where('code_book', $request->code)
            ->count();
        if ($sudahAda > 0) {
            return redirect()->back()->with('use', 'Buku sudah ada di keranjang!');
        }
        
        $tersedia = $buku->stock - $buku->being_borrowed;
        if ($tersedia <= 0) {
            return redirect()->back()->with('use', 'Stok buku sudah habis dipinjam!');
        }
        
        Detail_Borrow::create([
            'code_borrow' => $struk,
            'code_book'   => $request->code,
        ]);
        
        $buku->increment('being_borrowed');
        Borrow::where('code', $struk)->update([
            'return_date' => Carbon::today()->addDays(7)
        ]);
        
        return redirect()->back();
    }

    /**
     * Hapus Buku dari Keranjang
     */
    public function deleteCart($id)
    {
        // 🔒 Admin tidak boleh akses
        if (Auth::user()?->role === 'admin') {
            abort(403, 'Halaman ini hanya untuk peminjam.');
        }
        
        $detail = Detail_Borrow::findOrFail($id);
        $buku = Book::where('code', $detail->code_book)->first();
        if ($buku) {
            $buku->decrement('being_borrowed');
        }
        $detail->delete();
        return redirect()->back();
    }

    /**
     * Simpan & Selesaikan Peminjaman
     */
    public function addBorrow(Request $request)
    {
        // 🔒 Admin tidak boleh akses
        if (Auth::user()?->role === 'admin') {
            abort(403, 'Halaman ini hanya untuk peminjam.');
        }
        
        $struk = $request->session()->get('code_borrow');
        if (!$struk) {
            return redirect('borrow')->with('message', 'Transaksi tidak ditemukan, silakan mulai ulang.');
        }
        
        $hari = $request->return_date ?? 7;
        $hari = max(1, min(30, (int)$hari));
        
        Borrow::where('code', $struk)->update([
            'return_date' => Carbon::today()->addDays($hari),
            'status'      => 1,
        ]);
        
        $request->session()->forget('code_borrow');
        return redirect()->route('report')->with('berhasil', 'Peminjaman berhasil dicatat!');
    }
}