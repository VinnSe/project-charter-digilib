<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Detail_Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $userLogin = Auth::user();
        $isAdmin = $userLogin?->role === 'admin';

        $query = Borrow::query()
            ->join('detail_borrows', 'borrows.code', '=', 'detail_borrows.code_borrow')
            ->leftJoin('users', 'borrows.code_user', '=', 'users.code')
            ->select(
                'borrows.code',
                'borrows.created_at',
                'users.name as name_peminjam', // ← ubah nama agar jelas
                'users.code as code_user',
                'borrows.return_date',
                'borrows.status'
            );

        if (!$isAdmin) {
            $query->where(function($q) use ($userLogin) {
                $q->where('borrows.code_user', $userLogin->code)
                  ->orWhere('borrows.user_id', $userLogin->id);
            });
        }

        $dataTransaksi = $query->orderBy('borrows.created_at', 'desc')->distinct()->get();

        return view('layouts.report.transaction-report', ['data' => $dataTransaksi]);
    }

    public function checkForfeit(Request $request, $code)
    {
        $cekDenda = Borrow::where('code', $code)->select('return_date')->first();
        if (!$cekDenda) {
            return redirect()->back()->with('message', 'Data tidak ditemukan!');
        }

        $tglPengembalian = $cekDenda->return_date;
        $hariIni = Carbon::today();

        if ($hariIni > $tglPengembalian) {
            $selisihAngka = $hariIni->diffInDays($tglPengembalian);
            $denda = 500 * $selisihAngka;
            $request->session()->put('forfeit', $denda);
            return redirect()->back()->with('late', 'Terlambat mengembalikan buku');
        }

        return redirect()->back()->with('discipline', 'Tepat waktu');
    }

    public function doneForfeit($code)
    {
        $pinjam = Borrow::where('code', $code)->first();
        if (!$pinjam) {
            return redirect()->back()->with('message', 'Data tidak ditemukan!');
        }

        $pinjam->update(['status' => 1]);

        $kodeBuku = Detail_Borrow::where('code_borrow', $code)->pluck('code_book');
        foreach ($kodeBuku as $kode) {
            $buku = Book::where('code', $kode)->first();
            if ($buku) {
                $buku->decrement('being_borrowed');
            }
        }

        return redirect()->back()->with('done', 'Peminjaman selesai');
    }

    public function dataUser($code_user)
    {
        $userLogin = Auth::user();
        $isAdmin = $userLogin?->role === 'admin';

        $dataUser = User::where('id', $code_user)
            ->orWhere('code', $code_user)
            ->firstOrFail();

        if (!$isAdmin && $userLogin->id !== $dataUser->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $totalPinjam = Borrow::query()
            ->join('detail_borrows', 'borrows.code', '=', 'detail_borrows.code_borrow')
            ->where(function ($q) use ($dataUser) {
                $q->where('borrows.code_user', $dataUser->code)
                  ->orWhere('borrows.user_id', $dataUser->id);
            })
            ->selectRaw('count(borrows.code) as total')
            ->first();

        return view('layouts.report.data-user', [
            'user' => $dataUser,
            'totalPinjam' => $totalPinjam->total ?? 0
        ]);
    }
}