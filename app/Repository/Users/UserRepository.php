<?php

namespace App\Repository\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
     
    public function getUsers()
    {
        return User::All();
    }

    public function getUserId(int $id)
    {
        return User::find($id);
    }

    public function create(array $attribute)
    {
       return $this->create($attribute);
    }

    public function update($id, array $attribute)
    {
       $users = $this->findOrFail($id);
       $users->update($attribute);
    }

    public function getEmail(string $email)
    {
        return User::where('email', $email)->first();
    }



}











