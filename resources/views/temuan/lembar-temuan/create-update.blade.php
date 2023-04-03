<x-app-layout title="Lembar Temuan">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Lembar Temuan</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('temuan.index') }}">{{ __('Temuan') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __('Lembar Temuan') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" id="formAction" action="{{ isset($data) ? route('temuan.lembar-temuan.update', $data->id) : route('temuan.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="card card-outline">
                    <div class="card-body">
                        <div class="alert-message-error"></div>
                        <div class="text-center">
                            <p>Lembar Temuan</p>
                            <p>HAKIM PENGAWAS BIDANG</p>
                            <p>PENGADILAN AGAMA CIREBON</p>
                            <p class="d-flex align-items-center justify-content-center">SK Ketua Pengadilan Agama Cirebon Nomor W10-A16/
                                <span><input name="nomor_1" value="{{ old('nomor_1', ($detail->first()->nomor_1 ?? '')) }}" class="form-control" required/></span>/PS.00/
                                <span><input name="nomor_2" value="{{ old('nomor_2', ($detail->first()->nomor_2 ?? '')) }}" class="form-control" required/></span>/
                                <span><input name="nomor_3" value="{{ old('nomor_3', ($detail->first()->nomor_3 ?? '')) }}" class="form-control" required/></span></p>
                            <p class="d-flex align-items-center justify-content-center">Pelaksanaan Tanggal &nbsp;
                                <span><input type="date" name="tanggal_pelaksanaan_dari"  value="{{ old('tanggal_pelaksanaan_dari', (($detail->first() ?? null) ? date('Y-m-d', strtotime($detail->first()->tanggal_pelaksanaan_dari)) : '')) }}"  class="form-control" required/></span>
                                &nbsp; S.d &nbsp;
                                <span><input type="date" name="tanggal_pelaksanaan_sampai" value="{{ old('tanggal_pelaksanaan_sampai', (($detail->first() ?? null) ? date('Y-m-d', strtotime($detail->first()->tanggal_pelaksanaan_sampai)) : '')) }}"  class="form-control" required/></span></p>
                        </div>
                        <div class="mt-5">
                            <div>
                                <div>{{ $data->pengawas_bidang }}</div>
                                <div class="pl-4">
                                    <div>Pejabat Penanggung Jawab Tindak Lanjut : {{ ($data->penanggung_jawab_tindak_lanjut_tipe ? 'Panitera' : 'Sekertaris') . ' - ' . $data->penanggung_jawab_tindak_lanjut }}</div>
                                    <div class="list-form">
                                        @if (count($detail) > 0)
                                        @foreach ($detail as $item)
                                        <div class="form-details">
                                            <input type="hidden" name="id_detail[{{ $item->id }}]" value="{{ $item->id }}" />
                                            <div role="button" class="btn btn-danger remove-details mt-3">
                                                <i class="fa fa-times"></i>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="kondisi">
                                                        1. Kondisi
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('kondisi[{{ $item->id }}]') is-invalid @enderror"
                                                        name="kondisi[{{ $item->id }}]" required>{{ old("kondisi[$item->id]", ($item->kondisi ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kriteria">
                                                        2. Kriteria
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('kriteria[{{ $item->id }}]') is-invalid @enderror"
                                                        name="kriteria[{{ $item->id }}]" required>{{ old("kriteria[$item->id]", ($item->kriteria ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="sebab">
                                                        3. Sebab
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('sebab[{{ $item->id }}]') is-invalid @enderror"
                                                        name="sebab[{{ $item->id }}]" required>{{ old("sebab[$item->id]", ($item->sebab ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="akibat">
                                                        4. Akibat
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('akibat[{{ $item->id }}]') is-invalid @enderror"
                                                        name="akibat[{{ $item->id }}]" required>{{ old("akibat[$item->id]", ($item->akibat ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="rekomendasi">
                                                        5. Rekomendasi
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('rekomendasi[{{ $item->id }}]') is-invalid @enderror"
                                                        name="rekomendasi[{{ $item->id }}]" required>{{ old("rekomendasi[$item->id]", ($item->rekomendasi ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="foto_eviden[{{ $item->id }}]">
                                                        Upload Eviden Picture
                                                    </label>
                                                    <div id="image-preview" class="image-preview sm p-2 mb-3">
                                                        <div class="gallery gallery-sm">
                                                            <div class="gallery-item img-preview sm" id="foto_eviden-{{ $item->id }}" style="background-image: url('{{ asset($item->foto_eviden ?? '') }}');">
                                                                @if (isset($item->foto_eviden))
                                                                    <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="foto_eviden[{{ $item->id }}]">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </button>
                                                                    @else
                                                                    <label for="image-upload">Pilih Gambar</label>
                                                                    <input type="file" name="foto_eviden[{{ $item->id }}]">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <textarea
                                                        placeholder="Tulis keterangan gambar"
                                                        class="form-control @error('deskripsi_foto_eviden') is-invalid @enderror"
                                                        name="deskripsi_foto_eviden[{{ $item->id }}]">{{ old('deskripsi_foto_eviden', ($item->deskripsi_foto_eviden ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-details">
                                            <div role="button" class="btn btn-danger remove-details mt-3">
                                                <i class="fa fa-times"></i>
                                            </div>
                                            <input type="hidden" name="id_detail[]" />
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="kondisi">
                                                        1. Kondisi
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('kondisi[]') is-invalid @enderror"
                                                        name="kondisi[]" required>{{ old('kondisi[]', ($item->kondisi ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kriteria">
                                                        2. Kriteria
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('kriteria[]') is-invalid @enderror"
                                                        name="kriteria[]" required>{{ old('kriteria[]', ($item->kriteria ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="sebab">
                                                        3. Sebab
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('sebab[]') is-invalid @enderror"
                                                        name="sebab[]" required>{{ old('sebab[]', ($item->sebab ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="akibat">
                                                        4. Akibat
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('akibat[]') is-invalid @enderror"
                                                        name="akibat[]" required>{{ old('akibat[]', ($item->akibat ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <div class="col-md-6">
                                                    <label for="rekomendasi">
                                                        5. Rekomendasi
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('rekomendasi[]') is-invalid @enderror"
                                                        name="rekomendasi[]" required>{{ old('rekomendasi[]', ($item->rekomendasi ?? '')) }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="foto_eviden">
                                                        Upload Eviden Picture
                                                    </label>
                                                    <div id="image-preview" class="image-preview sm p-2 mb-3">
                                                        <div class="gallery gallery-sm">
                                                            <div class="gallery-item img-preview sm" id="foto_eviden[0]" style="background-image: url('{{ asset($item->foto_eviden ?? '') }}');">
                                                                @if (isset($item->foto_eviden))
                                                                    <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="foto_eviden[0]">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </button>
                                                                    @else
                                                                    <label for="image-upload">Pilih Gambar</label>
                                                                    <input type="file" name="foto_eviden[0]">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <textarea
                                                        placeholder="Tulis keterangan gambar"
                                                        class="form-control @error('deskripsi_foto_eviden[]') is-invalid @enderror"
                                                        name="deskripsi_foto_eviden[]">{{ old('deskripsi_foto_eviden[]', ($item->deskripsi_foto_eviden ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div role="button" class="btn btn-primary add-details">
                                            <i class="fas fa-plus"></i>
                                            Tambah Temuan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 d-flex align-items-center justify-content-between">
                            <a href="{{ route('temuan.edit', $data->id) }}" class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
    @push('script')
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/temuan/create-update.js') }}"></script>
    @endpush
</x-app-layout>
