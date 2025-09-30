<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;
use App\Models\JenisIdentitasModel;

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
        // 'role_id',
        'qr_code',
        'status',
        'approved_by',   // pastikan kolom ini ada di DB
        'checkin_by',    // pastikan kolom ini ada di DB
        'checkout_by',   // pastikan kolom ini ada di DB
        'checkin_at',
        'checkout_at',
        'approved_at'
    ];

    protected $casts = [
        'checkin_at' => 'datetime',
        'checkout_at' => 'datetime',
    ];


    // Relasi ke jenis identitas
    public function jenisIdentitas()
    {
        return $this->belongsTo(JenisIdentitasModel::class, 'jenis_identitas_id');
    }

    // Relasi ke user yang approve
    public function approvedBy()
    {
        return $this->belongsTo(UserModel::class, 'approved_by', 'id');
    }

    // Relasi ke user yang checkin
    public function checkinBy()
    {
        return $this->belongsTo(UserModel::class, 'checkin_by', 'id');
    }

    // Relasi ke user yang checkout
    public function checkoutBy()
    {
        return $this->belongsTo(UserModel::class, 'checkout_by', 'id');
    }

    // warna status   
public function getStatusColorAttribute()
{
    return match($this->status) {
        'belum_checkin' => 'warning',
        'checkin' => 'success',
        'approved' => 'primary',
        'checkout' => 'secondary',
        default => 'dark',
    };
}

public function getStatusTextAttribute()
{
    return match($this->status) {
        'belum_checkin' => 'Belum Checkin',
        'checkin' => 'Checkin',
        'approved' => 'Approved',
        'checkout' => 'Checkout',
        default => 'Unknown',
    };
}

}
