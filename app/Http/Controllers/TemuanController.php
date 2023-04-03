<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TemuanController extends Controller
{
    public function index()
    {
        return view('temuan.index');
    }

    public function create()
    {
        return view('temuan.create-update');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            "pengawas_bidang" => "required",
            "status" => "required",
            "penanggung_jawab_tindak_lanjut" => "required",
            "tindak_lanjut" => "required",
            "tanggal_tindak_lanjut" => "required",
            "triwulan" => "required",
        ]);

        $input['hakim_pengawas_bidang'] = Auth::user()->id;
        $input['penanggung_jawab_tindak_lanjut_tipe'] = penanggungJawabTipe($input['penanggung_jawab_tindak_lanjut']);

        $data = Temuan::create($input);

        return redirect(route('temuan.lembar-temuan.create', $data->id))
                    ->with('success', 'Data berhasil disimpan');

    }

    public function edit($id)
    {
        $data = Temuan::findOrFail($id);
        return view('temuan.create-update', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $data = Temuan::findOrFail($id);
        $request->validate([
            "pengawas_bidang" => "required",
            "status" => "required",
            "penanggung_jawab_tindak_lanjut" => "required",
            "tindak_lanjut" => "required",
            "tanggal_tindak_lanjut" => "required",
            "triwulan" => "required",
        ]);

        $input['penanggung_jawab_tindak_lanjut_tipe'] = penanggungJawabTipe($input['penanggung_jawab_tindak_lanjut']);
        $data->update($input);

        return redirect(route('temuan.lembar-temuan.create', $data->id))
                    ->with('success', 'Data berhasil disimpan');

    }

    public function dataTable(Request $request)
    {
        $data = Temuan::select('id', 'pengawas_bidang', 'status', 'penanggung_jawab_tindak_lanjut', 'penanggung_jawab_tindak_lanjut_tipe',
                                'created_at', 'tindak_lanjut', 'tanggal_tindak_lanjut', 'hakim_pengawas_bidang', 'triwulan')
                        ->with('detail', 'hakimPengawas:id,name')
                        ->latest()
                        ->filter($request);

        return DataTables::of($data)
                            ->addindexColumn()
                            ->addColumn('cetak', function($data) {
                                $cetak = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            <a href='$data->id'>
                                                <img src='".asset('assets/images/docx.png')."' style='height: 35px' />
                                            </a>
                                            <a href='$data->id'>
                                                <img src='".asset('assets/images/pdf.png')."' style='height: 35px' />
                                            </a>
                                         </div>";
                                return $cetak;
                            })->addColumn('action', function($data) {
                                $action = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            <a class='btn btn-primary btn-sm' href='".route('temuan.edit', $data->id)."'>
                                                <i class='fas fa-pencil-alt'></i>
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
                            })->rawColumns(['triwulan', 'foto_eviden', 'cetak', 'action'])
                           ->smart(true)
                           ->make(true);

    }

}
