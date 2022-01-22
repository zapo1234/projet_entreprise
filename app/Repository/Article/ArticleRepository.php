<?php

namespace App\Repository\Article;
use App\Models\Article;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;

class ArticleRepository implements ArticleInterface
{
  private $api;

  public function __construct(Apicall $api)
  {
    $this->api = $api;
  }

  public function getAll()
  {
    return Article::all();
  }

  public function Insert()
  {
      // recupérer les données de l'api
      $data = $this->api->getDataJson();
      $article = new Article();
      // insert data into table article
      foreach($data as $values) {
      // verifier l'unicité du nom
      $datas = $this->getName();
      dd($datas);
      if($datas) {
      $article->name = $values['billing']['first_name'];
      $article->categories = $values['total'];
      $article->total = $values['total'];
      $article->identifiant = $values['total'];
      $article->ref_id = $values['total'];
      // insert into bdd
      $article ->save();
      }
      else{
         dd('pas en accord');
      }
     }
    
    }


    public function getName(): array
    {
       // recupérer les names dans la base de données 
       $name_list = DB::table('articles')->select('name')->get();
       // transformer les retour objets en tableau
       $name_list = json_encode($name_list);
       $name_list = json_decode($name_list,true);
       // recupérer dans unn tableau les données name
       $donnees = [];
      foreach($name_list as $key => $values)
      {
         foreach($values as $val)
         {
           $donnees[] = $val;
         }
      }

      return $donnees;
    }

}