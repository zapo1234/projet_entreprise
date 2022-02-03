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
       // insert data into table article
       $total = [];
      // verifier l'unicité du nom,récupérer le tableau des names
       $datas = $this->getName();
      foreach($data as $values) 
      {
         if(!in_array($values['billing']['first_name'],$datas))
        {
           $article = new Article();
           $article->name = $values['billing']['first_name'];
           $article->categories = $values['total'];
           $article->total = $values['total'];
           $article->identifiant = $values['total'];
           $article->ref_id = $values['total'];
          // insert into bdd
           $article ->save();
        }
      }
    
    }

/**
 * 
 *@return array
 */

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
         // renvoi un tableau array de valeurs
         return $donnees;
    }

    public function getIdArticle(int $id)
    {
       return Article::find($id);
   }

}