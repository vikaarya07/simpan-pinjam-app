<?php

namespace App\Services;

// use Illuminate\Support\Facades\Http;
// use RuntimeException;

class WhatsAppService
{
    public function sendGroup(string $message): void
    {
        // $groupId = config('services.whatsapp.group_id');

        // $response = Http::post(
        //     config('services.whatsapp.url'),
        //     [
        //         'group_id' => $groupId,
        //         'message' => $message,
        //     ]
        // );

        // if ($response->failed()) {
        //     throw new RuntimeException(
        //         'Gagal mengirim WhatsApp Group.'
        //     );
        // }
    }

    public function send(string $phone, string $message): void
    {
        // $response = Http::post(
        //     config('services.whatsapp.url'),
        //     [
        //         'phone' => $phone,
        //         'message' => $message,
        //     ]
        // );

        // if ($response->failed()) {
        //     throw new RuntimeException(
        //         'Gagal mengirim WhatsApp.'
        //     );
        // }
    }
}
