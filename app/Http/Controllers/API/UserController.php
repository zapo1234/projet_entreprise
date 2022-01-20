<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $api;

    public function __construct(Apicall $api)
    {
      $this->api = $api;
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
       // renvoi de la vue
       return view('article.list', compact('ref'));
     }

     public function data()
     {
       $article = new Article();
       $donnes = $aticle->getUser();
       dd($donnes);
     }

}
