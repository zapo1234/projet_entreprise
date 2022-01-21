<?php

namespace App\Http\Service\FilePdf;

use PDF;

class CreatePdf
{
   public function createpdf(string $name,$data, string $namepdf, string $namepf)
   {
     return PDF::loadView($name, compact($namepdf))
     ->setPaper('a4', 'landscape')
     ->setWarnings(false)
     ->save(public_path("uplaod/'.$namepf.'"))
     ->stream();
     
   }

}







