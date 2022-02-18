<?php

namespace App\Repository\Users;

interface UserInterface
{
   public function getUsers(); // recupére tous les uers

   public function getUserId(int $id); // recupérer un user

   public function create(array $attribute); // créer un array

   public function update($id, array $attribute); // Modifier un user

   public function getEmail(string $email); // get 


}






