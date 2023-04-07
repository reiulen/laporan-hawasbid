<x-app-layout title="Temuan">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Tindak Lanjut Temuan</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('temuan.index') }}">{{ __('Temuan') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __('Tindak Lanjut Temuan') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" action="{{ isset($data) ? route('tindak-lanjut.update', $data->id) : route('tindak-lanjut.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="card card-outline">
                    <div class="card-header">
                        <div role="button" data-toggle="modal" data-target="#modalDetailTemuan" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                            Lihat Lembar Temuan
                        </div>
                    </div>
                    <div class="card-body">
                        <x-jet-validation-errors/>
                        <div class="form-group row mb-3">
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
                            <div class="col-md-6">
                                <label for="tanggal_tindak_lanjut">
                                   Tanggal Tindak Lanjut
                                </label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="tanggal_tindak_lanjut"
                                    value="{{ old('tanggal_tindak_lanjut', (($detail ?? null) ? date('Y-m-d', strtotime($detail->tanggal_tindak_lanjut)) : '')) }}" required/>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="tindak_lanjut">
                                   Tindak Lanjut
                                </label>
                                <textarea
                                    class="form-control"
                                    name="tindak_lanjut"
                                    rows="5"
                                    required>{{ old('tindak_lanjut',  ($detail->tindak_lanjut ?? '')) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="foto_eviden">
                                    Upload Eviden Picture
                                </label>
                                <div id="image-preview" class="image-preview sm p-2 mb-4">
                                    <div class="gallery gallery-sm">
                                        <div class="gallery-item img-preview sm" id="foto_eviden" style="background-image: url('{{ asset($detail->foto_eviden ?? '') }}');">
                                            @if (isset($detail->foto_eviden))
                                                <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="foto_eviden">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                @else
                                                <label for="image-upload">Pilih Gambar</label>
                                                <input type="file" name="foto_eviden">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <textarea
                                    placeholder="Tulis keterangan gambar"
                                    class="form-control @error('deskripsi_foto_eviden') is-invalid @enderror"
                                    name="deskripsi_foto_eviden">{{ old('deskripsi_foto_eviden', ($detail->deskripsi_foto_eviden ?? '')) }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                            <a href="{{ route('tindak-lanjut.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
        </div>
    </section>
    @push('modals')
    <div class="modal fade" id="modalDetailTemuan" tabindex="-1" aria-labelledby="modalDetailTemuanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lembar Temuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <iframe style="min-height: 700px; width: 100%"  src="/pdf/web/viewer.html?file={{ route('temuan.exportPDF', $data->id) }}"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endpush
    <!-- /.content -->
    @push('script')
    <script src="{{ asset('assets/dist/js/gallery-all.js') }}"></script>
    @endpush
</x-app-layout>
