<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany(TemuanDetail::class, 'temuan_id');
    }

    public function hakimPengawas()
    {
        return $this->belongsTo(User::class, 'hakim_pengawas_bidang');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'temuan_id', 'id');
    }

    public function scopeFilter($query, $filter)
    {
        return $query->when($filter->pengawas_bidang ?? false, function($query) use ($filter) {
            return $query->where('pengawas_bidang', 'LIKE', "%{$filter->pengawas_bidang}%");
        })->when($filter->status ?? false, function($query) use ($filter) {
            return $query->where('status', $filter->status);
        })->when($filter->pejabat_penanggung_jawab ?? false, function($query) use ($filter) {
            return $query->where('penanggung_jawab_tindak_lanjut', 'LIKE', "%{$filter->pejabat_penanggung_jawab}%");
        })->when($filter->tanggal_tindak_lanjut ?? false, function($query) use ($filter) {
            return $query->where('tanggal_tindak_lanjut',  $filter->tanggal_tindak_lanjut);
        })->when($filter->hakim_pengawas_bidang ?? false, function($query) use ($filter) {
            return $query->whereHas('hakimPengawas', function($query) use ($filter) {
                return $query->where('name', 'LIKE', "%{$filter->hakim_pengawas_bidang}%");
            });
        })->when($filter->triwulan ?? false, function($query) use ($filter) {
            return $query->where('triwulan',  $filter->triwulan);
        });
    }
}
