<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Repository\Article\ArticleRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\FilePdf\CreatePdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $api;
    private $pdf;
    private $articleRepository;

    public function __construct(
     Apicall $api,
     CreatePdf $pdf,
     ArticleRepository $articleRepository
     )
    {
      $this->api = $api;
      $this->pdf = $pdf;
      $this->articleRepository = $articleRepository;
    }
    
    /**
     * 
     *@return \Illuminate\Http\Response
     */
     public function list()
     {
         // recupérer les données de l'api
         $data = $this->api->getDataJson();
         if(count($data) >1)
         {
           $ref ='bonjour';
         }
         else{
          $ref ='bonsoir';
        }
         // insert into bdd (articles)
         $this->articleRepository->Insert();
         // renvoi de la vue
         return view('article.list', compact('ref'));
      }

      public function Pdfdata()
      {
      return $this->articleRepository->getAll();
      }

}
