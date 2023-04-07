<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TindakLanjutController extends Controller
{
    public function index()
    {
        return view('tindak-lanjut.index');
    }

    public function temuan($id)
    {
        $data = new Temuan;
        if(Auth::user()->role == 2)
            $data->where('hakim_pengawas_bidang', Auth::user()->id);
        else if(Auth::user()->role == 3)
            $data->where('penanggung_jawab_tindak_lanjut', Auth::user()->jabatan);
        $data = $data->findOrFail($id);
        $detail = $data->tindakLanjut ?? null;
        return view('tindak-lanjut.create-update', compact('data', 'detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "tanggal_tindak_lanjut" => "required",
            "tindak_lanjut" => "required",
            "foto_eviden" => "image|mimes:jpeg,png,jpg,gif,svg|max:4048",
            'status' => 'required',
        ]);

        $data = Temuan::findOrFail($id);
        $data->update([
            'status' => $request->status,
            // 'tanggal_tindak_lanjut' => date('Y-m-d', strtotime($request->tanggal_tindak_lanjut)),
        ]);
        $tindak_lanjut = TindakLanjut::find($data->tindakLanjut->id ?? null) ?? new TindakLanjut();
        $tindak_lanjut->temuan_id = $data->id;
        $tindak_lanjut->tanggal_tindak_lanjut = date('Y-m-d', strtotime($request->tanggal_tindak_lanjut));
        $tindak_lanjut->tindak_lanjut = $request->tindak_lanjut;
        if($request->file('foto_eviden'))
            $tindak_lanjut->foto_eviden = upload_file($request->file('foto_eviden'), 'tindak-lanjut', 'foto_eviden');
        $tindak_lanjut->deskripsi_foto_eviden = $request->deskripsi_foto_eviden;
        $tindak_lanjut->save();

        return redirect(route('tindak-lanjut.index'))
                    ->with('success', 'Data berhasil disimpan');

    }

    public function dataTable(Request $request)
    {
        $data = Temuan::select('id', 'pengawas_bidang', 'status', 'penanggung_jawab_tindak_lanjut', 'penanggung_jawab_tindak_lanjut_tipe',
                                'created_at', 'tindak_lanjut', 'tanggal_tindak_lanjut', 'hakim_pengawas_bidang', 'triwulan')
                        ->with('detail', 'hakimPengawas:id,name')
                        ->latest()
                        ->filter($request);
        if(Auth::user()->role == 2)
            $data->where('hakim_pengawas_bidang', Auth::user()->id);
        else if(Auth::user()->role == 3)
            $data->where('penanggung_jawab_tindak_lanjut', Auth::user()->jabatan);

        return DataTables::of($data)
                            ->addindexColumn()
                            ->addColumn('action', function($data) {
                                $action = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            <a class='btn btn-success text-nowrap btn-sm' target='_blank' href='".route('temuan.exportPDF',$data->id)."''>
                                                <i class='fas fa-eye'></i>
                                                Lihat Temuan
                                            </a>
                                            <a class='btn btn-primary text-nowrap btn-sm' href='".route('tindak-lanjut.temuan', $data->id)."'>
                                                <i class='fas fa-pencil-alt'></i>
                                                Tidak Lanjuti
                                            </a>
                                         </div>";
                                return $action;
                            })
                            ->addColumn('triwulan', function($data) {
                                return triwulan($data->triwulan);
                            })->addColumn('tanggal_tindak_lanjut', function($data) {
                                return date('d F Y', strtotime($data->tanggal_tindak_lanjut));
                            })->addColumn('foto_eviden', function($data) {
                                $detail = $data->detail ?? [];
                                $html = '';
                                foreach ($detail as $key => $item) {
                                    $html .= '<img src="'.asset($item->foto_eviden).'" style="height: 60px; width: 60px; object-fit:cover" /> ';
                                }
                                return '<div class="d-flex justify-content-center" style="gap: 20px;">'.$html.'</div>';
                            })->rawColumns(['triwulan', 'foto_eviden', 'action'])
                           ->smart(true)
                           ->make(true);

    }
}
