<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Temuan;
use App\Mail\TemuanEmail;
use App\Jobs\SendMailTemuan;
use Illuminate\Http\Request;
use App\Events\SendEmailTemuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Event;
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
        $data = new Temuan;
        if(Auth::user()->role == 2)
            $data->where('hakim_pengawas_bidang', Auth::user()->id);
        $data = $data->findOrFail($id);
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
        if(Auth::user()->role == 2)
            $data->where('hakim_pengawas_bidang', Auth::user()->id);

        return DataTables::of($data)
                            ->addindexColumn()
                            ->addColumn('cetak', function($data) {
                                $cetak = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            <a href='".route('temuan.exportPDF',$data->id)."' target='_blank'>
                                                <img src='".asset('assets/images/pdf.png')."' style='height: 35px' />
                                            </a>
                                         </div>";
                                return $cetak;
                            })->addColumn('action', function($data) {
                                $action = "<div class='d-flex align-items-center' style='gap: 10px'>
                                            <div>
                                                <div class='btn btn-success btn-sm text-nowrap send-email' role='button' data-id='$data->id'>
                                                    <i class='fas fa-envelope'></i>
                                                    Kirim Email
                                                </div>
                                            </div>
                                            <a class='btn btn-primary btn-sm' href='".route('temuan.edit', $data->id)."'>
                                                <i class='fas fa-pencil-alt'></i>
                                            </a>
                                            <div role='button' class='btn btn-danger btn-sm btn-hapus' data-title='Lembar Temuan' data-id='$data->id'>
                                                <i class='fas fa-trash-alt'></i>
                                            </div>
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
                            })->rawColumns(['triwulan', 'foto_eviden', 'cetak', 'action'])
                           ->smart(true)
                           ->make(true);

    }

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
            $job = new SendMailTemuan($user, $data, $data->detail);
            $this->dispatch($job);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Email berhasil dikirim dan sedang dalam antrian'
        ]);
    }


    public function exportPDF($id)
    {
        $data = Temuan::with('detail')->findOrFail($id);
        $detail = $data->detail ?? [];

        $cetak = "Lembar Temuan Hakim Pengawas Bidang Pengadilan Agama Cirebon $data->penanggung_jawab_tindak_lanjut ";

        // return view('temuan.exportPdf', compact('data', 'detail'));

        $pdf = PDF::loadview('temuan.exportPdf', compact('data', 'detail'))
                    ->setPaper('A4', 'portrait');
        return $pdf->stream($cetak);
    }

    public function destroy($id)
    {
        $data = Temuan::find($id);
        if($data->detail) {
            foreach($data->detail as $item) {
                if(isset($item->foto_eviden))
                    File::delete($item->foto_eviden);
            }
        }

        if($data->tindakLanjut) {
            foreach($data->tindakLanjut ?? [] as $item) {
                if(isset($item->foto_eviden))
                    File::delete($item->foto_eviden);
            }
        }

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function detailPreview(Request $request)
    {
        $data = Temuan::select('id', 'status',  'tanggal_tindak_lanjut',  'triwulan')
                        ->latest()
                        ->filter($request);
        if(Auth::user()->role == 2)
            $data->where('hakim_pengawas_bidang', Auth::user()->id);

        return DataTables::of($data)
                            ->addindexColumn()
                            ->addColumn('link', function($data) {
                                $link = "<a href=".route('temuan.exportPDF', $data->id)." target='_blank'>".route('temuan.exportPDF', $data->id)."</a>";
                                return $link;
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
                            })->rawColumns(['link'])
                           ->smart(true)
                           ->make(true);

    }
}
