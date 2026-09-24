<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp lewat Fonnte.
     */
    public static function send(string $phone, string $message): bool
    {
        $token = config('services.fonnte.token');

        if (! $token) {
            Log::warning('FONNTE_TOKEN belum diset, notifikasi WhatsApp dilewati.');
            return false;
        }

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'  => self::formatPhone($phone),
            'message' => $message,
        ]);

        if (! $response->successful()) {
            Log::error('Gagal kirim WhatsApp: ' . $response->body());
            return false;
        }

        return true;
    }

    /**
     * Ubah format nomor 08xxx jadi 628xxx (format wajib Fonnte).
     */
    private static function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}