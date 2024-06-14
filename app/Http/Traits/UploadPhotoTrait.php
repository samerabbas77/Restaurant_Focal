<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;
use League\Flysystem\Visibility;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;

trait UploadPhotoTrait
{
    public function storeFile($file)
    {
        
        // Get the original file name
        $originalName = $file->getClientOriginalName();
        
        // Check for double extensions in the file name
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new HttpResponseException(response()->json(['message' => trans('general.notAllowedAction')], 403));
        }
            
        $fileName =  time() .Str::random(32) ;//. '.' .'jpg'
     

        // Save the Image and get the path within the storage disk
        try {
            $file->move(public_path('images'), $fileName);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => $e->getMessage()], 500));
        }

        return  $fileName;
       
    }
}
