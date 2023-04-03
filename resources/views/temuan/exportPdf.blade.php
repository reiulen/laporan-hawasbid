<html>
    <head>
        <title>Lembar Temuan Hakim Pengawas Bidang Pengadilan Agama Cirebon</title>
        <style>
            * {
                font-family: 'Arial', sans-serif;
            }

            .bold {
                font-weight: bold;
            }

            .font-size-12 {
                font-size: 12px;
            }

            .font-size-14 {
                font-size: 14px;
            }

            .text-center {
                text-align: center;
            }
            .page_break { page-break-before: always; }
        </style>
    </head>
    <body>
        @foreach ($detail as $item)
        <div>
            <div class="text-center font-size-14 bold">
                <p>HAKIM PENGAWAS BIDANG</p>
                <p>PENGADILAN AGAMA CIREBON</p>
                <p><i>SK Ketua Pengadilan Agama Cirebon Nomor W10-A16/{{ $item->nomor_1 }}/PS.00/{{ $item->nomor_2 }}/{{ $item->nomor_3 }}</i></p>
                <p>Pelaksanaan Tanggal {{ dateMonthIndo($item->tanggal_pelaksanaan_dari) }} S.d {{ dateMonthIndo($item->tanggal_pelaksanaan_sampai) }}</p>
            </div>
            <ol class="font-size-14" style="list-style-type: upper-alpha; margin-top: 50px; display: flex; justify-content: center">
                <li>
                    <div class="bold" style="margin-bottom: 5px">Bidang Manajemen Peradilan</div>
                    <div style="margin-bottom: 5px">Pejabat Penanggung Jawab Tindak Lanjut : {{ ($data->penanggung_jawab_tindak_lanjut_tipe ? 'Panitera' : 'Sekertaris') . ' - ' . $data->penanggung_jawab_tindak_lanjut }}</div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Kondisi:</div>
                        <div>{{ $item->kondisi }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Kriteria:</div>
                        <div>{{ $item->kriteria }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Sebab:</div>
                        <div>{{ $item->sebab }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Akibat:</div>
                        <div>{{ $item->akibat }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Rekomendasi:</div>
                        <div>{{ $item->rekomendasi }}</div>
                    </div>
                    <div style="margin-top: 20px">
                        <div class="bold" >TAMPILAN HASIL CETAK EVIDEN</div>
                        <div>
                            <img src="{{ asset($item->foto_eviden) }}" style="height: 250px" />
                        </div>
                    </div>
                </li>
            </ol>
        </div>
        <div class="page_break"></div>
        @endforeach
    </body>
</html>
