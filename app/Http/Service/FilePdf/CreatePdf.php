<?php

namespace App\Http\Service\FilePdf;

use App\Models\Article;
use PDF;

class CreatePdf
{
    public function createpdf()
    {
       $data = Article::all();
       return PDF::loadView('article.data', compact('data'))
       ->setPaper('a4', 'landscape')
       ->setWarnings(false)
       ->save(public_path("Upload/fichier.pdf"))
       ->stream();
    }

}







