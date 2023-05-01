<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Temuan;
use App\Mail\TemuanEmail;
use App\Jobs\SendMailTemuan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TindakLanjutController extends Controller
{
    public function sendEmail(Request $request, $id)
    {
        $data = Temuan::find($id);
        if(!$data)
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);

        if(count($request->user_send) < 1)
            return response()->json([
                'status' => false,
                'message' => 'Pilih user yang akan dikirim email'
            ]);

        $user = User::whereIn('id', $request->user_send)->get();
        if(count($user) > 0) {
            // foreach($user as $item) {
            //     Mail::to($item->email)->send(new TemuanEmail($item, $data, $data->detail, true));
            // }
            $job = new SendMailTemuan($user, $data, $data->detail, true);
            $this->dispatch($job);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Email berhasil dikirim dan sedang dalam antrian'
        ]);
    }

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
        $lembar_temuan = $data->detail ?? [];
        $detail = $data->tindakLanjut ?? null;
        return view('tindak-lanjut.create-update', compact('data', 'detail', 'lembar_temuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id.*' => 'required',
            "tanggal_tindak_lanjut.*" => "required",
            "tindak_lanjut.*" => "required",
            "foto_eviden.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:4048",
            // 'status.*' => 'required',
        ]);


        $data = Temuan::findOrFail($id);
        $tindak_lanjuts = $data->tindakLanjut ?? [];
        $foto_eviden = $request->file('foto_eviden') ?? [];
        $tindak_lanjut = [];
        foreach($tindak_lanjuts as $tl) {
            $tindak_lanjut[$tl->id] = $tl;
        }
        $ids = $request->id ?? [];
        foreach($ids as $id) {
            $tindak_lanjut = $tindak_lanjuts[$id] ?? new TindakLanjut();
            $tindak_lanjut->temuan_id = $data->id;
            // $tindak_lanjut->status = $request->status[$id] ?? '';
            $tindak_lanjut->tanggal_tindak_lanjut = date('Y-m-d', strtotime($request->tanggal_tindak_lanjut[$id] ?? ''));
            $tindak_lanjut->tindak_lanjut = $request->tindak_lanjut[$id] ?? '';
            if($foto_eviden[$id] ?? null)
                $tindak_lanjut->foto_eviden = upload_file($foto_eviden[$id], 'tindak-lanjut', 'foto_eviden');
            $tindak_lanjut->deskripsi_foto_eviden = $request->deskripsi_foto_eviden[$id] ?? '';
            $tindak_lanjut->temuan_details_id = $id;
            $tindak_lanjut->save();
        }

        $data->update([
            'status' => 2,
            // 'tanggal_tindak_lanjut' => date('Y-m-d', strtotime($request->tanggal_tindak_lanjut)),
        ]);
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
                                $buttonKirimEmail = '';
                                if($data->tindakLanjut)
                                    $buttonKirimEmail = "<div>
                                                            <div class='btn btn-dark btn-sm text-nowrap send-email' role='button' data-id='$data->id'>
                                                                <i class='fas fa-envelope'></i>
                                                                Kirim Email
                                                            </div>
                                                        </div>";
                                $action = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            $buttonKirimEmail
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
                                    if(isset($item->foto_eviden))
                                        $html .= '<img src="'.asset($item->foto_eviden).'" style="height: 60px; width: 60px; object-fit:cover" /> ';
                                }
                                return '<div class="d-flex justify-content-center" style="gap: 20px;">'.$html.'</div>';
                            })->rawColumns(['triwulan', 'foto_eviden', 'action'])
                           ->smart(true)
                           ->make(true);

    }
}
