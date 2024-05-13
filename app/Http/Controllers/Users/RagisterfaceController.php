<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RagisterfaceController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $img =  $request->face;
        $folderPath = "public/img";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.jpeg';

        $file = $folderPath . $fileName;
        $face = Storage::putFile($file, $image_base64);

        //regster face
        $response = Http::attach(
            'face', file_get_contents($face), $fileName, ['Content-Type' => 'image/jpeg']
        )->put('http://localhost:3333/api/register', [
            'userId' => $user->id,
        ]);

        if($response->successful()) {
            dd($response->body());
        }

        dd('ok');
        if ($user->photo !== 'public/img/avatar.png') {
            Storage::delete($user->photo);
        }
    }
}
