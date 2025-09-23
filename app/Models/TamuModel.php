<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
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
    ];

    // Relasi ke jenis identitas
    public function jenisIdentitas()
    {
        return $this->belongsTo(JenisIdentitas::class, 'jenis_identitas_id');
    }

    // Relasi ke role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi ke user yang approve/checkin/checkout (opsional, diisi oleh admin/security)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function checkinBy()
    {
        return $this->belongsTo(User::class, 'checkin_by');
    }

    public function checkoutBy()
    {
        return $this->belongsTo(User::class, 'checkout_by');
    }
}
