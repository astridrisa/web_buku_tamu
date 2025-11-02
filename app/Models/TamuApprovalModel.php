<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TamuModel;
use App\Models\UserModel;

class TamuApprovalModel extends Model
{
    use HasFactory;

    protected $table = 'tamu_approvals';

    protected $fillable = [
        'tamu_id',
        'pegawai_id',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime'
    ];

    // ===== RELASI =====

    /**
     * Relasi ke tamu yang di-approve
     */
    public function tamu()
    {
        return $this->belongsTo(TamuModel::class, 'tamu_id');
    }

    /**
     * Relasi ke pegawai yang meng-approve
     */
    public function pegawai()
    {
        return $this->belongsTo(UserModel::class, 'pegawai_id');
    }

    // ===== SCOPES =====

    /**
     * Scope untuk approval hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereBetween('approved_at', [
            now()->startOfDay(), 
            now()->endOfDay()
        ]);
    }

    /**
     * Scope untuk approval oleh pegawai tertentu
     */
    public function scopeByPegawai($query, $pegawaiId)
    {
        return $query->where('pegawai_id', $pegawaiId);
    }

    /**
     * Scope untuk approval bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('approved_at', [
            now()->startOfMonth(), 
            now()->endOfMonth()
        ]);
    }
}