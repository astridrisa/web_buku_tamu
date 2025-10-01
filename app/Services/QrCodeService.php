<?php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\TamuModel;

class QrCodeService
{
    /**
     * Generate QR Code dan simpan ke storage
     */
    public function generateQrCode($data, $filename)
    {
        // Generate QR Code sebagai PNG
        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($data);

        // Path untuk menyimpan QR Code
        $path = 'qrcodes/' . $filename;
        
        // Simpan ke storage/app/public/qrcodes
        Storage::disk('public')->put($path, $qrCode);

        // Return full path untuk attachment email
        return storage_path('app/public/' . $path);
    }

    /**
     * Generate QR Code untuk tamu
     */
    public function generateTamuQrCode(TamuModel $tamu)
    {
        // Data yang akan di-encode ke QR Code
        $data = json_encode([
            'id' => $tamu->id,
            'nama' => $tamu->nama,
            'qr_code' => $tamu->qr_code,
            'checkin_at' => $tamu->checkin_at ? $tamu->checkin_at->format('Y-m-d H:i:s') : null,
            'tujuan' => $tamu->tujuan,
        ]);

        $filename = 'tamu-' . $tamu->id . '-' . time() . '.png';
        
        return $this->generateQrCode($data, $filename);
    }

    /**
     * Hapus QR Code dari storage
     */
    public function deleteQrCode($filename)
    {
        $path = 'qrcodes/' . $filename;
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }
        
        return false;
    }
}