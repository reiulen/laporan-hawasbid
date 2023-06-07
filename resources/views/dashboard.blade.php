<x-app-layout title="Dashboard">
    <x-content_header>
        <div class="col-sm-8">
            <h4>Selamat Datang, {{ Auth::user()->name }}</h4>
        </div>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
               @if (Auth::user()->role == 1)
               <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: #F7CE46">
                        <div class="inner text-white pl-5">
                            <h1 style="font-size: 50px"><b>{{ $pengguna }}</b></h1>
                        </div>
                        <div class="icon" style="
                        position: absolute;
                        top: 0;
                        right: 115px;">
                            <i class="fas fa-book-reader" style="color: rgba(255, 255, 255, 0.193)"></i>
                        </div>
                        <a href="#" class="small-box-footer text-right px-4">Pengguna</a>
                    </div>
                </div>
               @endif
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: #e0b32d">
                        <div class="inner text-white pl-5">
                            <h1 style="font-size: 50px"><b>{{ $temuan->count() }}</b></h1>
                        </div>
                        <div class="icon" style="
                        position: absolute;
                        top: 0;
                        right: 135px;">
                            <i class="fas fa-clipboard-list" style="color: rgba(255, 255, 255, 0.193)"></i>
                        </div>
                        <a href="#" class="small-box-footer text-right px-4">Temuan</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: #e02d2d">
                        <div class="inner text-white pl-5">
                            <h1 style="font-size: 50px"><b>{{ $belum_tindak }}</b></h1>
                        </div>
                        <div class="icon" style="
                        position: absolute;
                        top: 0;
                        right: 135px;">
                            <i class="fas fa-clipboard-list" style="color: rgba(255, 255, 255, 0.193)"></i>
                        </div>
                        <a href="#" class="small-box-footer text-right px-4">Belum Ditindak lanjuti</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: #39e02d">
                        <div class="inner text-white pl-5">
                            <h1 style="font-size: 50px"><b>{{ $sudah_tindak }}</b></h1>
                        </div>
                        <div class="icon" style="
                        position: absolute;
                        top: 0;
                        right: 135px;">
                            <i class="fas fa-clipboard-check" style="color: rgba(255, 255, 255, 0.193)"></i>
                        </div>
                        <a href="#" class="small-box-footer text-right px-4">Sudah Ditindak lanjuti</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                $i = 0;
                $triwulan = [
                            'I',
                            'II',
                            'III',
                            'IV',
                        ];
                @endphp
                @foreach ($triwulan as $tl)
                <div class="col-md-6">
                    {{-- <div class="mb-4 d-flex align-items-end" style="gap: 10px;">
                        @php
                            $tahun = [
                                '2021',
                                '2022',
                                '2023',
                                '2024',
                                '2025',
                                '2026',
                                '2027',
                                '2028',
                                '2029',
                            ]
                        @endphp
                        <div>
                            <select class="form-control" name="">
                                @foreach ($tahun as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                            <div class="d-flex align-items-center" style="gap: 5px">
                                <div>
                                    <input type="number" class="form-control" value="{{ date('Y') }}" style="max-width: 90px" />
                                </div>
                                <button class="btn btn-primary">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label>Tahun</label>
                            <input type="number" name="tahun-{{ $tl }}" class="form-control tahun_triwulan" value="{{ date('Y') }}" style="max-width: 90px" />
                        </div>
                        <a href="" class="btn btn-primary">
                            Download Rekap Triwulan {{ $tl }}
                        </a>
                    </div> --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Triwulan {{ $tl }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A. Manajemen Peradilan</td>
                                <td>
                                    <a href="#" class="detailPreview" data-type="A. Manajemen Peradilan" data-triwulan='{{ ++$i }}'  data-triwulanM='{{ $tl }}'>
                                        Lihat semua link preview
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>B. Administrasi Perkara</td>
                                <td>
                                    <a href="#" class="detailPreview" data-type="B. Administrasi Perkara" data-triwulan='{{ ++$i }}'  data-triwulanM='{{ $tl }}'>
                                        Lihat semua link preview
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>C. Administrasi Persidangan</td>
                                <td>
                                    <a href="#" class="detailPreview" data-type="C. Administrasi Persidangan" data-triwulan='{{ ++$i }}'  data-triwulanM='{{ $tl }}'>
                                        Lihat semua link preview
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>D. Pelayanan Publik</td>
                                <td>
                                    <a href="#" class="detailPreview" data-type="D. Pelayanan Publik" data-triwulan='{{ ++$i }}'  data-triwulanM='{{ $tl }}'>
                                        Lihat semua link preview
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>E. Administrasi Umum</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#detailPreview"  data-type="E. Administrasi Umum" data-triwulan='{{ ++$i }}'  data-triwulanM='{{ $tl }}'>
                                        Lihat semua link preview
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @push('modals')
    <div class="modal fade" id="detailPreview" tabindex="-1" aria-labelledby="detailPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detailPreviewLabel">Detail Preview <span id="typePn"></span> <span id="triwulanM"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="overflow-auto p-4">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2" width="10px">No</th>
                            <th rowspan="2" class="text-nowrap">Link Preview</th>
                            <th class="text-nowrap">Tanggal/Bulan/Tahun <br/> Temuan</th>
                            <th>Status</th>
                        </tr>
                        <tr class="text-center">
                            <th class="text-nowrap" style="min-width: 180px">
                                <input type="date" name="tanggal_tindak_lanjut" class="form-control" />
                            </th>
                            <th class="text-nowrap" style="min-width: 180px">
                                <select class="form-control" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="1">Belum ditindaklanjuti</option>
                                    <option value="2">Sudah ditindaklanjuti</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
    @endpush
    @include('lib.datatable')
    @push('script')
    <script>
        $('.tahun_triwulan').on('change', function() {
            let tahun = $(this).val();
            let name = $(this).attr('name');
            console.log(tahun,name);
            // let triwulan = $(this).data('triwulan');
            // let url = `${url}/admin/${triwulan}/export-pdf/${tahun}`;
            // url = url + `?tahun=${tahun}&triwulan=${triwulan}`;
            // $(this).next().attr('href', url);
        });
        $('input').on('keyup', function() {
            setTimeout(function() {
                table.draw();
            }, 900);
        }).on('change', function() {
            setTimeout(function() {
                table.draw();
            }, 900);
        });

        $('select').on('change', function() {
            table.draw();
        });

        let type = '';
        let triwulan = '';
        let table = null;
        $('.detailPreview').on('click', function() {
            type = $(this).data('type');
            triwulan = $(this).data('triwulan');
            let triwulanM = $(this).data('triwulanm');
            $('#typePn').text(type);
            $('#triwulanM').text(`Triwulan ${triwulanM}`);
            if(table) {
                table.draw();
            }
            $('#detailPreview').modal('show');
        });
        $('#detailPreview').on('shown.bs.modal', function() {
            if ( $.fn.dataTable.isDataTable( '#example1' ) ) {
                table.draw();
            }else {
                table = $("#example1").DataTable({
                    lengthMenu: [
                        [10, 25, 50, 100, 500, -1],
                        [10, 25, 50, 100, 500, "All"],
                    ],
                    searching: false,
                    responsive: false,
                    lengthChange: true,
                    autoWidth: false,
                    order: [],
                    pagingType: "full_numbers",
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari...",
                        processing:
                            '<div class="spinner-border text-info" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            "</div>",
                        paginate: {
                            Search: '<i class="icon-search"></i>',
                            first: "<i class='fas fa-angle-double-left'></i>",
                            previous: "<i class='fas fa-angle-left'></i>",
                            next: "<i class='fas fa-angle-right'></i>",
                            last: "<i class='fas fa-angle-double-right'></i>",
                        },
                    },
                    oLanguage: {
                        sSearch: "",
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `{{ url('') }}/admin/dashboard/previewDetail`,
                        method: "POST",
                        data: function (d) {
                            d.pengawas_bidang = type;
                            d.triwulan = triwulan;
                            const input = $('input');
                            const select = $('select');
                            input.each(function() {
                                let name = $(this).attr('name');
                                let value = $(this).val();
                                if (value != '')
                                    d[name] = value;
                            });
                            select.each(function() {
                                let name = $(this).attr('name');
                                let value = $(this).val();
                                if (value != '')
                                    d[name] = value;
                            });
                            return d;
                        },
                    },
                    columns: [
                        {
                            name: "created_at",
                            data: "DT_RowIndex",
                        },
                        {
                            name: "link",
                            data: "link",
                            orderable: false,
                        },
                        {
                            name: "tanggal_tindak_lanjut",
                            data: "tanggal_tindak_lanjut",
                            orderable: false,
                        },
                        {
                            name: "status",
                            data: function(data) {
                                return data.status == 1 ? 'Belum ditindaklanjuti' : 'Sudah ditindaklanjuti'
                            },
                            orderable: false,
                        },
                    ],
                });
            }
        });
        // $('#detailPreview').on('hidden.bs.modal', function() {
        //     $('#example1').find('tbody')
        // });
    </script>
    @endpush
</x-app-layout>
