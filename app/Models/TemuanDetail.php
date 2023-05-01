<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemuanDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tindak_lanjut()
    {
        return $this->hasOne(TindakLanjut::class, 'temuan_details_id', 'id');
    }
}
