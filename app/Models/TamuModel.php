<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamuModel extends Model  
{
    use HasFactory;

    protected $table = 'tamu';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'tujuan', 
        'email',
        'jumlah_rombongan',
        'jenis_identitas_id',
        'role_id',
        'qr_code',
        'status'
    ];

    public function jenisIdentitas()
    {
        return $this->belongsTo(JenisIdentitasModel::class, 'jenis_identitas_id');
    }
}