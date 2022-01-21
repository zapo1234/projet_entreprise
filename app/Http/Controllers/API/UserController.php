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
       // insert data into table article
       foreach($data as $values) {
         $article = new Article();
         $article->name = $values['billing']['first_name'];
         $article->categories = $values['total'];
         $article->total = $values['total'];
         $article->identifiant = $values['total'];
         $article->ref_id = $values['total'];
        }
         // insert into bdd
         $article ->save();
         // renvoi de la vue
         return view('article.list', compact('ref'));
     }

     public function data()
     {
       $article = new Article();
       
     }

}
