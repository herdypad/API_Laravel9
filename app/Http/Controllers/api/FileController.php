<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    // use HasImage;

    public function DownloadFile($id)
    {
        return response()->download(public_path('uploads/'.$id), $id);

    }




    public function UploadFile(Request $request)
    {
        // dd($request->all());
        $file = Request()->file('fileName');
        $fileName = $request->fileName->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        $photoUrl = url('api/file/'.$fileName);
        return response()->json(['url' => $photoUrl],200);

    }

    public function UploadFIle3(Request $request){
        $image = $this->uploadImage($request, $path = public_path("/"));


    }


    //Mengunakan trait
    public function UploadFIle1(Request $request){

        // dd($request->all());

        if (!$request->has('fileName')) {
            return response()->json(['message' => 'Missing file'], 422);
        }

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);


    }
}
