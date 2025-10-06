<?php

namespace App\Services;

use App\Models\TamuModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class QrCodeService
{
    public function generateTamuQrCode(TamuModel $tamu): string
    {
        try {
            $qrUrl = route('tamu.qr.show', $tamu->qr_code);
            
            Log::info("Generating QR Code for tamu: {$tamu->id}, URL: {$qrUrl}");

            // Generate QR Code SVG
            $qrCode = QrCode::size(300)
                ->margin(2)
                ->errorCorrection('H')
                ->encoding('UTF-8')
                ->generate($qrUrl);

            // ✅ Buat folder jika belum ada
            $directory = storage_path('app' . DIRECTORY_SEPARATOR . 'qrcodes');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                Log::info("Created directory: {$directory}");
            }

            // ✅ Simpan file langsung dengan file_put_contents
            $filename = 'qrcode_' . $tamu->id . '_' . time() . '.svg';
            $fullPath = $directory . DIRECTORY_SEPARATOR . $filename;
            
            file_put_contents($fullPath, $qrCode);
            
            // Verifikasi file
            if (file_exists($fullPath)) {
                $fileSize = filesize($fullPath);
                Log::info("✅ QR Code saved successfully at: {$fullPath} (Size: {$fileSize} bytes)");
            } else {
                Log::error("❌ QR Code file NOT created at: {$fullPath}");
                throw new \Exception("Failed to save QR Code file");
            }

            return $fullPath;

        } catch (\Exception $e) {
            Log::error("Error generating QR Code: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function generateQrCodeBase64($data): string
    {
        $svg = QrCode::size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->encoding('UTF-8')
            ->generate($data);
            
        return base64_encode($svg);
    }

    public function deleteOldQrCodes(int $tamuId): void
    {
        try {
            $directory = storage_path('app' . DIRECTORY_SEPARATOR . 'qrcodes');
            if (File::exists($directory)) {
                $files = File::files($directory);
                foreach ($files as $file) {
                    if (str_contains($file->getFilename(), "qrcode_{$tamuId}_")) {
                        File::delete($file);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning("Failed to delete old QR codes: " . $e->getMessage());
        }
    }
}