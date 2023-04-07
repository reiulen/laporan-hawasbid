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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
