<?php

namespace App\Repository\Article;

interface ArticleInterface
{
    public function getAll(); // récupérer tous les articles
    
    public function Insert(); // insert datas articles

    public function getName();// recupérer le nom du user.

}

