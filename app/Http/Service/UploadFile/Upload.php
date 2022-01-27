<?php

namespace App\Http\Service\UpladFile;

use Illuminate\Http\Request;


class  Upload
{
   /**
   * upload file.
   *
   * @return $this
   */
   public function uploadfile(string $file, Request $request)
   {
       if($request->hasfile('file')) {
        // l'extension du fichier 
       $extension = $file->getClientOriginalExtension();
       // renommer le fichier
       $filename = time().'.'.$extension;
       // enregsitrer le fichier dans le dossier upload.
       $file->move(public_path('upload'), $filename);
       // message succees
       return redirect('upload.file')->with('status', 'succees files upload');
    
       }

   }

}








