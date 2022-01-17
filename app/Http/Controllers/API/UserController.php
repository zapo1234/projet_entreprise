<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function list()
     {
      // recupérer les données 
      $this->api->getDataJson();
      // renvoi de la vue
      return view('article.list');
     }

}
