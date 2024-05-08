<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FacecheckController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $img =  $request->image;
        $folderPath = "storage/users/img/";

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

        // Use Http::attach to attach the image file
        $response = Http::attach(
            'face', file_get_contents($file), $fileName, ['Content-Type' => 'image/jpeg']
        )->put('https://api-facerecognation.tulangbawangkab.go.id/api/check', [
            'userId' => Auth::user()->id
        ]);

        // Delete the temporary file after sending
        unlink($file);

        // Handle response
        return response()->json([
            "sucess"    => true,
            "data"      => $response->body(),
        ]);
    }
}
