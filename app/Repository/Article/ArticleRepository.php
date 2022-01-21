<?php

namespace App\Repository\Article;
use App\Models\Article;
use App\Http\Service\CallApi\Apicall;

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
        $article = new Article();
        $article->name = $values['billing']['first_name'];
        $article->categories = $values['total'];
        $article->total = $values['total'];
        $article->identifiant = $values['total'];
        $article->ref_id = $values['total'];
       }
        // insert into bdd
        $article ->save();
     }

}