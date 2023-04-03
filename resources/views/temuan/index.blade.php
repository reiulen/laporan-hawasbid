<x-app-layout title="Temuan">
    <x-content_header>
        <div class="col-sm-6">
            <h4 class="text-primary">Temuan</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Temuan') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="d-md-flex">
                                <div>
                                    <a class="btn btn-primary border-0" href="{{ route('temuan.create') }}"><i class="fa fa-plus px-1"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="overflow-auto">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="10" class="text-center">Review Lembar Temuan Hakim Pengawas Bidang Pengadilan Agama Cirebon</td>
                                    </tr>
                                    <tr class="text-center">
                                        <th rowspan="2" width="10px">No</th>
                                        <th class="text-nowrap">Pengawas Bidang</th>
                                        <th>Status</th>
                                        <th class="text-nowrap">Pejabat Penanggung <br/> Jawab Tindak Lanjut</th>
                                        <th class="text-nowrap">Tanggal/Bulan/Tahun <br/> Tindak Lanjut</th>
                                        <th class="text-nowrap">Hakim Pengawas <br/> Bidang</th>
                                        <th class="text-nowrap">Triwulan Ke</th>
                                        <th rowspan="2">Eviden</th>
                                        <th rowspan="2">Cetak</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th class="text-nowrap" style="min-width: 180px">
                                            <input name="pengawas_bidang" class="form-control" />
                                        </th>
                                        <th class="text-nowrap" style="min-width: 180px">
                                            <select class="form-control" name="status">
                                                <option value="">Pilih Status</option>
                                                <option value="1">Belum ditindaklanjuti</option>
                                                <option value="2">Sudah ditindaklanjuti</option>
                                            </select>
                                        </th>
                                        <th class="text-nowrap" style="min-width: 180px">
                                            <input name="pejabat_penanggung_jawab" class="form-control" />
                                        </th>
                                        <th class="text-nowrap" style="min-width: 180px">
                                            <input type="date" name="tanggal_tindak_lanjut" class="form-control" />
                                        </th>
                                        <th class="text-nowrap" style="min-width: 180px">
                                            <input name="hakim_pengawas_bidang" class="form-control" />
                                        </th>
                                        <th class="text-nowrap" style="min-width: 100px">
                                            @php
                                                $triwulan = [
                                                    1 => 'I',
                                                    2 => 'II',
                                                    3 => 'III',
                                                    4 => 'IV',
                                                ];
                                            @endphp
                                            <select class="form-control" name="triwulan">
                                                <option value="">Pilih Triwulan</option>
                                                @foreach ($triwulan as $key => $tw)
                                                <option value="{{ $key }}">{{ $tw }}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    @include('lib.datatable')
    @push('script')
    <script src="{{ asset('assets/dist/js/pages/temuan/index.js') }}"></script>
    @endpush
</x-app-layout>
