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

            .line-height {
                line-height: 1.5;
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
            <div class="font-size-14" style="list-style-type: upper-alpha; margin-top: 50px; display: flex; justify-content: center">
                <div class="bold" style="margin-bottom: 5px">{{ explode('.', $data->pengawas_bidang)[0] ?? '' }}. <span style="padding-left: 5px">{{ explode('.', $data->pengawas_bidang)[1] ?? '' }}</span></div>
                <div style="padding-left: 30px" class="line-height">
                    <div style="margin-bottom: 5px">Pejabat Penanggung Jawab Tindak Lanjut : {{ ($data->penanggung_jawab_tindak_lanjut_tipe ? 'Panitera' : 'Sekertaris') . ' - ' . $data->penanggung_jawab_tindak_lanjut }}</div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">1. Kondisi:</div>
                        <div style="padding-left: 17px">{{ $item->kondisi }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">2. Kriteria:</div>
                        <div style="padding-left: 17px">{{ $item->kriteria }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">3. Sebab:</div>
                        <div style="padding-left: 17px">{{ $item->sebab }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">4. Akibat:</div>
                        <div style="padding-left: 17px">{{ $item->akibat }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">5. Rekomendasi:</div>
                        <div style="padding-left: 17px">{{ $item->rekomendasi }}</div>
                    </div>
                    <div style="margin-top: 20px">
                        <div class="bold" >TAMPILAN HASIL CETAK EVIDEN</div>
                        @if ($item->foto_eviden ?? null)
                        <div style="margin-top: 8px">
                            <img src="{{ public_path($item->foto_eviden) }}" style="height: 250px; width: 100%" />
                        </div>
                        <div>{{ $item->deskripsi_foto_eviden }}</div>
                            @else
                            <div style="padding-left: 17px">Tidak ada foto eviden</div>
                        @endif
                    </div>
                    @if ($data->tindakLanjut)
                    <div class="bold" style="margin-top: 20px; margin-bottom: 5px">TINDAK LANJUT:</div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">1. Tanggal Tindak Lanjut:</div>
                        <div style="padding-left: 17px">{{ $data->tindakLanjut ? dateMonthIndo($data->tindakLanjut->tanggal_tindak_lanjut, 'd F Y') : '' }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">2. Keterangan Tindak Lanjut:</div>
                        <div style="padding-left: 17px">{{ $data->tindakLanjut->tindak_lanjut ?? ''  }}</div>
                    </div>
                    <div style="margin-bottom: 5px">
                        <div class="bold" style="margin-bottom: 5px">Foto Eviden Tindak Lanjut:</div>
                       @if ($data->tindakLanjut->foto_eviden_tindak_lanjut ?? null)
                       <div style="padding-left: 17px">
                            <img src="{{ public_path($item->foto_eviden) }}" style="height: 250px; width: 100%" />
                        </div>
                        <div>{{ $item->deskripsi_foto_eviden }}</div>
                        @else
                        <div style="padding-left: 17px">Tidak ada foto eviden tindak lanjut</div>
                       @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- @if (!$detail->last()->id == $item->id) --}}
        <div class="page_break"></div>
        {{-- @endif --}}
        @endforeach
    </body>
</html>
