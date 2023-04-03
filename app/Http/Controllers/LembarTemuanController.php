<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\TemuanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LembarTemuanController extends Controller
{
    public function create($id)
    {
        $data = Temuan::findOrFail($id);
        $detail = $data->detail;
        return view('temuan.lembar-temuan.create-update', compact('data', 'detail'));
    }

    public function updateTemuan(Request $request, $id)
    {
        $input = $request->all();
        $validasi = Validator::make($input, [
            "nomor_1" => "required",
            "nomor_2" => "required",
            "nomor_3" => "required",
            "tanggal_pelaksanaan_dari" => "required",
            "tanggal_pelaksanaan_sampai" => "required",
            "kondisi" => "required|array",
            "kriteria" => "required|array",
            "sebab" => "required|array",
            "akibat" => "required|array",
            "rekomendasi" => "required|array",
            "kondisi.*" => "required",
            "kriteria.*" => "required",
            "sebab.*" => "required",
            "akibat.*" => "required",
            "rekomendasi.*" => "required",
        ]);

        if ($validasi->fails())
            return response()->json([
                'status' => false,
                'message' => $validasi->errors()->all()
            ]);

        $data = Temuan::with('detail')->find($id);
        if(!$data)
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);

        $detailTemuan = $data->detail;
        $dataDetail = [];
        foreach($detailTemuan as $d) {
            $dataDetail[$d->id] = $d;
        }

        $idDetail = $request->id_detail ?? [];
        $kondisi = $request->kondisi ?? [];
        $kriteria = $request->kriteria ?? [];
        $sebab = $request->sebab ?? [];
        $akibat = $request->akibat ?? [];
        $rekomendasi = $request->rekomendasi ?? [];
        $fotoEviden = $request->file('foto_eviden') ?? [];
        $deskripsiFotoEviden = $request->deskripsi_foto_eviden ?? [];

        foreach($idDetail as $key => $id) {
            if($dataDetail[$id] ?? null)
                $validasi = Validator::make($input, [
                    "foto_eviden.{$key}" => "image|mimes:jpeg,png,jpg,gif,svg|max:4048",
                ]);
            else
                $validasi = Validator::make($input, [
                    "foto_eviden.{$key}" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:4048",
                ]);

            if ($validasi->fails())
                return response()->json([
                    'status' => false,
                    'message' => $validasi->errors()->all()
                ]);
            else {
                $detail = $dataDetail[$id] ?? new TemuanDetail();
                $detail->temuan_id = $data->id;
                $detail->nomor_1 = $request->nomor_1;
                $detail->nomor_2 = $request->nomor_2;
                $detail->nomor_3 = $request->nomor_3;
                $detail->tanggal_pelaksanaan_dari = $request->tanggal_pelaksanaan_dari;
                $detail->tanggal_pelaksanaan_sampai = $request->tanggal_pelaksanaan_sampai;
                $detail->kondisi = $kondisi[$key] ?? '';
                $detail->kriteria = $kriteria[$key] ?? '';
                $detail->sebab = $sebab[$key] ?? '';
                $detail->akibat = $akibat[$key] ?? '';
                $detail->rekomendasi = $rekomendasi[$key] ?? '';
                if($fotoEviden[$key] ?? null) {
                    if($detail->foto_eviden){
                        $foto_eviden[$key] = upload_file($fotoEviden[$key], 'foto_eviden', 'temuan');
                        File::delete($detail->foto_eviden);
                    }else
                        $foto_eviden[$key] = upload_file($fotoEviden[$key], 'foto_eviden', 'temuan');
                }
                $detail->foto_eviden = $foto_eviden[$key] ?? $detail->foto_eviden;
                $detail->deskripsi_foto_eviden = $deskripsiFotoEviden[$key] ?? '';
                $detail->save();
            }
        }

        $detailDelete = $detailTemuan->whereNotIn('id', $idDetail);
        if(count($detailDelete) > 0) {
            foreach($detailDelete as $item) {
                if($item->foto_eviden)
                    File::delete($item->foto_eviden);
                $item->delete();
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);

    }
}
