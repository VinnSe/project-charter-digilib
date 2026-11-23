<x-html-layout>
    <x-slot:title>
        Laporan | Digilib
    </x-slot>
    <x-sidebar-layout></x-sidebar-layout>
    <div id="main" class="pt-xl-0 pt-sm-3 mt-0 ml-1 px-4">
        <div class="row">
            <div class="col-6 order-md-1">
                <div class="m-0 pt-2">
                    <h3 class="m-0 p-0 text-white">Laporan Transaksi</h3>
                    <p class="text-white-50">Informasi transaksi yang telah dilakukan</p>
                </div>
            </div>
            <div class="mt-3 col-6 order-md-2">
                <nav class="breadcrumb-header float-end" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="text-white-50 breadcrumb-item active">Laporan</li>
                        <li class="breadcrumb-item"><a class="text-white" href="transaction-report">Laporan Transaksi</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div style="border-radius: 4px; border-bottom: 2px solid" class="card p-0 mt-3 border-primary">
                    <div style="position: absolute; top: -25px; left: 10px; border-radius: 5px; padding: 10px 10px; border-bottom: 2px solid; text-align: center; box-shadow: 0 0 10px rgba(0, 0, 0, .15);"
                         class="card border-primary">
                        <h6 style="margin: 0px;">Laporan Transaksi</h6>
                    </div>
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Tanggal Pelayanan</th>
                                        <th>Nomor Struk</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>
                                            @if(!empty($item->code_user))
                                                <a href="{{ route('data-user', ['code_user' => $item->code_user]) }}" style="color: inherit">
                                                    {{ $item->name_peminjam ?? 'Tidak ada nama' }}
                                                </a>
                                            @else
                                                {{ $item->name_peminjam ?? 'Tidak ada nama' }}
                                            @endif
                                        </td>
                                        <td>{{ $item->return_date }}</td>
                                        <td class="text-center">
                                            @if ($item->status == 0)
                                                <a href="#" class="btn btn-danger btn-sm check"
                                                   data-code="{{ $item->code }}"
                                                   data-name="{{ $item->name_peminjam }}">
                                                    <i class="bi bi-cash"></i> Detail
                                                </a>
                                            @else
                                                <i class="bi bi-check-all"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Belum ada riwayat transaksi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-html-script-layout>
        <script>
            $(document).ready(function() {
                let jquery_datatable = $("#table").DataTable();

                $('.check').click(function(e) {
                    e.preventDefault();
                    var borrow_code = $(this).attr('data-code');
                    var borrow_name = $(this).attr('data-name');

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-secondary ms-2',
                            denyButton: 'btn btn-danger ms-2'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'Butuh Informasi?',
                        icon: 'info',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Check Denda',
                        denyButtonText: 'Lunaskan',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "check-forfeit/" + borrow_code;
                        } else if (result.isDenied) {
                            window.location = "done-forfeit/" + borrow_code;
                        }
                    });
                });
            });

            @if (Session::has('discipline'))
                Swal.fire({
                    title: '<strong>Tidak Telat Mengembalikan</strong>',
                    icon: 'info',
                    confirmButtonText: 'Oke'
                });
            @elseif (Session::has('late'))
                Swal.fire({
                    title: '<strong>Telat Mengembalikan</strong>',
                    icon: 'warning',
                    text: "Dia telat, dan harus membayar Rp {{ Session::get('forfeit') }}",
                    confirmButtonText: 'Oke'
                });
            @elseif (Session::has('done'))
                Swal.fire({
                    title: '<strong>Peminjaman Terselesaikan</strong>',
                    icon: 'success',
                    confirmButtonText: 'Oke'
                });
            @endif
        </script>
    </x-html-script-layout>
</x-html-layout>