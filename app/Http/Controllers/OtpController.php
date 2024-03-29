<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OtpController extends Controller
{
    public function store(Request $request)
    {
        $bearer = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiI2NjA2MDk2MGJhNTFkMDJkNTgwYjYwM2UiLCJmdWxsTmFtZSI6IlVtYWVkaSIsImZpcnN0TmFtZSI6IlVtYWVkaSIsIm1pZGRsZU5hbWUiOiIiLCJsYXN0TmFtZSI6IlVtYWVkaSIsIm1vYmlsZXBob25lIjoiNjI4NTc0MTQ5MjA0NSIsImNvdW50cnlDb2RlIjoiIiwicm9sZSI6ImNsaWVudCIsImV4cCI6MTcxMTkyOTU5OTAwMCwiaWF0IjoxNzExNjc1NDAzLCJpc3MiOiJraXJpbXBlc2FuLnJpc3Rla211c2xpbS5jb20ifQ.NSySJE05G6rQP7LrSoqEwRpnMKU2cNuIe10ROJs7Do4';
        $otp = Str::random(4);
        $response = Http::withToken($bearer)
            ->post('https://apiks.ristekmuslim.com/client/v1/message/send-text', [
                'instanceID' => '66060960c302c5956a9ac401',
                'phone' => $request->phone,
                'message' => 'Masukan Kode OTP: *' . $otp . '*. Kode OTP berlaku selama 15 menit. JANGAN beritahu kode ini ke siapa pun',
                'serverSend' => 'false',
            ]);

        if ($response->successful()) {
            return $this->success($response->json());
        } else {
            return $this->error($response->body());
        }
    }

    public function verif()
    {
        return view('otp.verif');
    }
}
