<x-html-layout>
    <x-slot:title>Pinjam | Digilib</x-slot>
    <x-sidebar-layout></x-sidebar-layout>
    <div id="main" class="pt-xl-0 pt-sm-3 mt-0 ml-1 px-4">
        <div class="row">
            <div class="col-6">
                <h3 class="text-white">Pinjam</h3>
                <p class="text-white-50">Aplikasi meminjam buku</p>
            </div>
            <div class="col-6 text-end">
                <nav class="breadcrumb-header float-end" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active text-white-50">Dashboard</li>
                        <li class="breadcrumb-item text-white"><a href="stock">Pinjam</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-dark border-primary mt-3">
                    <div class="card-body">
                        {{-- INVOICE & PEMINJAM --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-6">
                                <span class="text-white-50">Invoice:</span>
                                <strong class="text-white ms-1">{{ Session::get('code_borrow') ?? '-' }}</strong>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="text-white-50">Peminjam:</span>
                                <strong class="text-success ms-1">{{ Auth::user()->name }}</strong>
                            </div>
                        </div>

                        {{-- KODE BUKU --}}
                        <div class="card border-success mb-4">
                            <div class="card-body">
                                <h5 class="text-success mb-3"><i class="bi bi-book"></i> Masukkan Kode Buku</h5>
                                <form action="{{ route('cart') }}" method="GET" class="mb-4">
                                    <div class="row align-items-center">
                                        <label class="col-lg-2 col-form-label text-white">Kode Buku</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="kode_buku" class="form-control" required autofocus placeholder="Contoh: 12345" value="{{ request('kode_buku') }}">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-success w-100">Cari Buku</button>
                                        </div>
                                    </div>
                                </form>

                                {{-- HASIL PENCARIAN BUKU --}}
                                @if(request('kode_buku'))
                                    @php
                                        $kodeDicari = request('kode_buku');
                                        $bukuDitemukan = ($dataBuku ?? collect())->firstWhere('code', $kodeDicari);
                                    @endphp
                                    @if($bukuDitemukan)
                                        @php
                                            $tersedia = ($bukuDitemukan->stock ?? 0) - ($bukuDitemukan->being_borrowed ?? 0);
                                        @endphp
                                        <div class="alert alert-info border mb-4">
                                            <h6 class="fw-bold text-success mb-2">✅ Buku Ditemukan</h6>
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <span class="text-white-50 small">Kode</span>
                                                    <p class="fw-bold">{{ $bukuDitemukan->code }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-white-50 small">Judul</span>
                                                    <p class="fw-bold mb-0">{{ $bukuDitemukan->title }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="text-white-50 small">Penulis</span>
                                                    <p class="mb-0">{{ $bukuDitemukan->writer ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <span class="text-white-50 small d-block">Stok Tersedia</span>
                                                    <span class="badge bg-{{ $tersedia > 0 ? 'success' : 'danger' }} fs-6">{{ $tersedia }}</span>
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    @if($tersedia > 0)
                                                        <form action="{{ route('add-cart') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                            <input type="hidden" name="code" value="{{ $bukuDitemukan->code }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="bi bi-hand-thumbs-up"></i> Ambil
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>Ambil</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-danger mb-4">
                                            ❌ Kode buku <strong>{{ $kodeDicari }}</strong> tidak ditemukan.
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- DAFTAR SEMUA BUKU YANG TERSEDIA --}}
                        <h5 class="text-white mb-3 border-top pt-4">
                            <i class="bi bi-list-ul me-2"></i>Daftar Buku Tersedia
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">Kode</th>
                                        <th>Judul Buku</th>
                                        <th width="15%">Penulis</th>
                                        <th width="10%" class="text-center">Stok Tersedia</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $adaBuku = false; @endphp
                                    @foreach ($dataBuku ?? collect() as $buku)
                                        @php
                                            $stok = $buku->stock ?? 0;
                                            $sedangDipinjam = $buku->being_borrowed ?? 0;
                                            $tersedia = $stok - $sedangDipinjam;
                                        @endphp
                                        @if($tersedia > 0)
                                            @php $adaBuku = true; @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><code>{{ $buku->code }}</code></td>
                                                <td class="fw-medium">{{ $buku->title }}</td>
                                                <td>{{ $buku->writer ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-success fs-6">{{ $tersedia }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('add-cart') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                        <input type="hidden" name="code" value="{{ $buku->code }}">
                                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                                            <i class="bi bi-plus-circle me-1"></i> Pilih
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @if(!$adaBuku)
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox me-2 fs-5"></i>
                                                Saat ini tidak ada buku yang tersedia untuk dipinjam
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {{-- BUKU YANG SUDAH DIAMBIL --}}
                        <div class="card border-warning mt-4">
                            <div class="card-body">
                                <h5 class="text-warning mb-3"><i class="bi bi-cart-check"></i> Buku yang Diambil</h5>
                                @php $daftar = $isi ?? collect(); @endphp
                                @if($daftar->isNotEmpty())
                                    @foreach ($daftar as $item)
                                        <div class="row align-items-center border-top pt-3 pb-3">
                                            <div class="col-md-2">
                                                <span class="text-white-50 small">Kode</span>
                                                <input type="text" value="{{ $item->code }}" class="form-control form-control-sm" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <span class="text-white-50 small">Judul</span>
                                                <input type="text" value="{{ $item->title }}" class="form-control form-control-sm" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <form action="{{ route('add-borrow') }}" method="POST">
                                                    @csrf
                                                    <span class="text-white-50 small">Lama Pinjam (Hari)</span>
                                                    <div class="d-flex gap-2">
                                                        <input type="number" name="return_date" value="7" min="1" max="30" class="form-control form-control-sm">
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="bi bi-check-lg"></i> Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="text-white-50 small d-block">&nbsp;</span>
                                                <a href="{{ route('delete-cart', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm w-100"
                                                    onclick="return confirm('Hapus buku ini dari keranjang?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-white-50 mb-0">
                                        Masukkan kode buku di atas atau klik tombol <strong>"Pilih"</strong> pada daftar buku di bawah.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-html-script-layout>
        <script>
            @if (Session::has('message'))
                Swal.fire({ icon: 'error', title: 'Kode Tidak Ditemukan', timer: 2000, showConfirmButton: false });
            @elseif (Session::has('berhasil'))
                Swal.fire({ icon: 'success', title: 'Peminjaman Berhasil!', timer: 2000, showConfirmButton: false });
            @endif
        </script>
    </x-html-script-layout>
</x-html-layout>