<x-html-layout>
    <x-slot:title>
        Dashboard | Digilib
    </x-slot>
    <x-sidebar-with-profile-layout></x-sidebar-with-profile-layout>
    
    <div id="main" class="pt-5 pt-xl-0 pt-lg-5 pt-md-5 pt-sm-5 px-3">
        <div class="text-white h4">Selamat Datang di Digital - Library, {{ Auth::user()->name }}</div>
        
        <section class="row">
            {{-- ✅ HANYA UNTUK USER — Tampilkan statistik --}}
            @if (Auth::user()->role !== 'admin')
                {{-- Total Dipinjam --}}
                <div class="col-12 col-lg-4">
                    <div class="py-2 my-0">
                        <div class="col-12">
                            <div style="border-radius: 4px;" class="card my-3">
                                <div class="card-body px-4">
                                    <h6 class="text-muted font-semibold">Total Buku Yang Dipinjam</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalPinjam }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tabel Buku Sering Dipinjam --}}
                <div style="border-radius: 5px; height: min-content" class="card col-lg-8 mt-4">
                    <div style="top: -25px; position: absolute; width: auto; box-shadow: 0 4px 10px rgba(0, 0, 0, .1); padding: 10px 15px; border-radius: 10px;"
                        class="card-header">
                        <h5 class="mb-0">Buku Yang Sering Dipinjam</h5>
                    </div>
                    <div class="card-body pt-4 mt-0">
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Buku</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($populer as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">{{ $item->total }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            Belum ada riwayat peminjaman buku
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            
            {{-- ✅ UNTUK ADMIN — Tampilan selamat datang --}}
            @if (Auth::user()->role === 'admin')
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-body px-4 py-4">
                            <h5 class="text-white mb-2">Selamat Datang di Panel Admin</h5>
                            <p class="text-white-50 mb-0">Gunakan menu di sebelah kiri untuk mengelola perpustakaan.</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
    
    <x-html-script-layout>
        {{-- Script lain jika ada --}}
    </x-html-script-layout>
</x-html-layout>