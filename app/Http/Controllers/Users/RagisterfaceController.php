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
        $folderPath = "storage/img/";

        // Decode base64 string
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // Generate a unique filename
        $fileName = uniqid() . '.jpg';
        $file = $folderPath . $fileName;

        // Save the decoded base64 string as an image file
        file_put_contents($file, $image_base64);

        if ($user->photo !== 'avatar.png') {
            if(file_exists($folderPath . $user->photo)) {
                unlink($folderPath . $user->photo);
            }
        }

        $user->update([
            'photo' => $fileName,
        ]);
        // Use Http::attach to attach the image file
        $response = Http::attach(
            'face', file_get_contents($file), $fileName, ['Content-Type' => 'image/jpeg']
        )->put('http://localhost:3333/api/register', [
            'userId' => $user->id,
        ]);

        if($response->successful()) {
            return $response->body();
        }else {
            return $this->error('Internal Server Error!');
        }
    }
}
