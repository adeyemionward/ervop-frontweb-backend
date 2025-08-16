<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait HandleFileUpload
{
    function handleFileUploadImage($hasFile, $fileName, $dir){
        if ($hasFile) {
            if ($img = $fileName) {
                $ImageName = str_replace(' ', '', $fileName->getClientOriginalName());
                $uniqueFileName = time() . '_' . $ImageName;
                $ImagePath = $dir.'/'. $uniqueFileName;
                $img->move(public_path($dir), $uniqueFileName);
                return $ImagePath;
            }
        }
    }


    function handleFileUploadArr($files, $dir) {
        $filePaths = [];

        foreach ($files as $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                $imageName = str_replace(' ', '', $file->getClientOriginalName());
                $uniqueFileName = time() . '_' . $imageName;
                $imagePath = $dir . '/files/' . $uniqueFileName;
                $file->move(public_path($dir . '/files/'), $uniqueFileName);
                $filePaths[] = $imagePath; //
            }
        }

        return $filePaths; // returns like ["image1.jpg", "image2.pdf"]
    }



    function handleFileUploadPDF($hasFile, $fileName, $dir){
        if ($hasFile) {
            if ($img = $fileName) {
                $ImageName = str_replace(' ', '', $fileName->getClientOriginalName());//$fileName->getClientOriginalName();
                $uniqueFileName = time() . '_' . $ImageName;
                $ImagePath = $dir.'/pdf/' . $uniqueFileName;
                $img->move(public_path($dir.'/pdf/'), $uniqueFileName);
                return $ImagePath;
            }
        }
    }
}
