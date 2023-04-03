<x-app-layout title="Temuan">
    <x-content_header>
        <div class="col-sm-6">
            <h4>{{ isset($data) ? 'Edit' : 'Tambah' }} Temuan</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('temuan.index') }}">{{ __('Temuan') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __( (isset($data) ? 'Edit' : 'Tambah') . ' Temuan') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" action="{{ isset($data) ? route('temuan.update', $data->id) : route('temuan.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="card card-outline">
                    <div class="card-body">
                        <x-jet-validation-errors/>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="pengawas_bidang">
                                   Pengawas Bidang
                                </label>
                                @php
                                    $pengawas_bidang = [
                                        'A. Manajemen Peradilan',
                                        'B. Administrasi Perkara',
                                        'C. Administrasi Persidangan',
                                        'D. Pelayanan Publik',
                                        'E. Administrasi Umum',
                                    ];
                                @endphp
                                <select class="form-control select2" name="pengawas_bidang" required>
                                    <option value="">Pilih Pengawas Bidang</option>
                                    @foreach ($pengawas_bidang as $rmp)
                                        <option value="{{ $rmp }}" {{ old('pengawas_bidang', ($data->pengawas_bidang ?? '')) == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status">
                                    Status
                                 </label>
                                 @php
                                     $status = [
                                        1 => 'Belum ditidaklanjuti',
                                        2 => 'Sudah ditidaklanjuti',
                                     ];
                                 @endphp
                                 <select class="form-control select2" name="status" required>
                                     <option value="">Pilih Status</option>
                                     @foreach ($status as $key => $rmp)
                                         <option value="{{ $key }}" {{ old('status', ($data->status ?? '')) == $key ? 'selected' : '' }}>{{ $rmp }}</option>
                                     @endforeach
                                 </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="role">
                                 Pejabat Penanggung Jawab Tindak Lanjut
                                </label>
                                @php
                                    $penanggung_jawab = [
                                        "PANITERA" => [
                                            'Panmud Permohonan',
                                            'Panmud Gugatan',
                                            'Panmud Hukum'
                                        ],
                                        "SEKERTARIS" => [
                                            'Kasubag PTIP',
                                            'Kasubag Umum & Keuangan',
                                            'Kasubag Kepegawaian'
                                        ]
                                    ];
                                @endphp
                                <select class="form-control select2" name="penanggung_jawab_tindak_lanjut" required>
                                    <option value="">Pilih Pejabat Penanggung Jawab Tindak Lanjut</option>
                                    @foreach ($penanggung_jawab as $key => $pnj)
                                       <optgroup label="{{ $key }}">
                                        @foreach ($pnj as $pn)
                                            <option value="{{ $pn }}" {{ old('penanggung_jawab_tindak_lanjut', ($data->penanggung_jawab_tindak_lanjut ?? '')) == $pn ? 'selected' : '' }}>{{ $pn }}</option>
                                        @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tindak_lanjut">
                                   Tindak Lanjut
                                </label>
                                @php
                                    $tindak_lanjut = [
                                        "A. Manajemen Peradilan",
                                        "B. Administrasi Perkara",
                                        "C. Administrasi Persidangan",
                                        "D. Pelayanan Publik",
                                        "E. Administrasi Umum"
                                    ];
                                @endphp
                                <select class="form-control select2" name="tindak_lanjut" required>
                                    <option value="">Pilih Tindak Lanjut</option>
                                    @foreach ($tindak_lanjut as $key => $rmp)
                                        <option value="{{ $rmp }}" {{ old('tindak_lanjut', ($data->tindak_lanjut ?? '')) == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_tindak_lanjut">
                                   Tanggal Tindak Lanjut
                                </label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="tanggal_tindak_lanjut"
                                    value="{{ old('tanggal_tindak_lanjut', (($data ?? null) ? date('Y-m-d', strtotime($data->tanggal_tindak_lanjut)) : '')) }}" required/>
                            </div>
                            <div class="col-md-6">
                                <label for="triwulan">
                                   Triwulan
                                </label>
                                @php
                                    $triwulan = [
                                                1 => 'I',
                                                2 => 'II',
                                                3 => 'III',
                                                4 => 'IV',
                                            ];
                                @endphp
                                <select class="form-control select2" name="triwulan" required>
                                    <option value="">Pilih Triwulan</option>
                                    @foreach ($triwulan as $key => $rmp)
                                        <option value="{{ $key }}" {{ old('triwulan', ($data->triwulan ?? '')) == $key ? 'selected' : '' }}>{{ $rmp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <a href="{{ route('temuan.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                            <button class="btn btn-primary">
                                Lanjut
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-app-layout>
