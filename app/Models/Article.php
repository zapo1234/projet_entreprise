<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    private $user = 2;
    private $data = [];


    public function getUser()
    {
      $this->user = $user;
    }

    public function setUser()
    {
        $this->user = $user;
        $this->user;
    }
}
