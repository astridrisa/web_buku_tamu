<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;
use App\Models\JenisIdentitasModel;

/**
 * @mixin IdeHelperTamuModel
 */
class TamuModel extends Model
{
    use HasFactory;

    protected $table = 'tamu';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'tujuan',
        'nama_pegawai',
        'foto', 
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
        'approved_at' => 'datetime'
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

    public function approvals()
    {
        return $this->hasMany(TamuApprovalModel::class, 'tamu_id')
                    ->orderBy('approved_at', 'asc');
    }

    /**
     * Relasi many-to-many ke pegawai yang approve
     */
    public function approvedByPegawais()
    {
        return $this->belongsToMany(UserModel::class, 'tamu_approvals', 'tamu_id', 'pegawai_id')
                    ->withTimestamps()
                    ->withPivot('approved_at')
                    ->as('approval')
                    ->orderByPivot('approved_at', 'asc');
    }

    // ===== HELPER METHODS =====

    /**
     * Cek apakah pegawai tertentu sudah approve
     */
    public function isApprovedBy($pegawaiId): bool
    {
        // Cek di table tamu_approvals
        return TamuApprovalModel::where('tamu_id', $this->id)
                          ->where('pegawai_id', $pegawaiId)
                          ->exists();
    }

    /**
     * Hitung jumlah pegawai yang sudah approve
     */
    public function getTotalApproversAttribute(): int
    {
        return TamuApprovalModel::where('tamu_id', $this->id)->count();
    }

    /**
     * Daftar nama pegawai yang sudah approve
     */
    public function getApproverNamesAttribute(): array
    {
        return TamuApprovalModel::where('tamu_id', $this->id)
                          ->with('pegawai')
                          ->get()
                          ->pluck('pegawai.name')
                          ->toArray();
    }

    // warna status   
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'belum_checkin' => 'warning',
            'checkin' => 'success',
            'approved' => 'primary',
            'checkout' => 'danger',
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

    // Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('img/default-avatar.png');
    }

    public function scopeApproved($query)
{
    // ambil semua kolom, tapi hanya yang statusnya approved
    return $query->where('status', 'approved');
}

    /**
     * Scope untuk tamu yang belum di-approve oleh pegawai tertentu
     */
    public function scopeNotApprovedBy($query, $pegawaiId)
    {
        return $query->whereDoesntHave('approvals', function($q) use ($pegawaiId) {
            $q->where('pegawai_id', $pegawaiId);
        });
    }


}
