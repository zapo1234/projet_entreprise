<?php

namespace App\Repository\Users;

interface UserInterface
{
   public function getAll(); // recupére tous les articles

   public function getUserId(); // recupérer un user

   public function create(array $attributes); // créer un array


}






