<?php

namespace App\Repository\Article;

interface ArticleInterface
{
    public function getAll(); // récupérer tous les articles

    public function getIdArticle(int $id); // recupérer un article
    
    public function Insert(); // insert datas articles

    public function getName(): array;// recupérer les nom des article existant.

}

