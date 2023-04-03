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
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
