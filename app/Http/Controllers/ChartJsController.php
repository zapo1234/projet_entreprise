<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Carbon\Carbon;

class ChartJsController extends Controller
{
    public function chartjs()
    {   
        if(Auth::check())
        {
          $x = Auth::user()->id;
          dd($x);
        }
        // initialiser un tableau de date.
        $year = ['2018','2019','2020','2021','2022','2023'];
        
        // initialiser un array vide pour recupérer les données
        $user = [];
        foreach ($year as $key => $value) {
            // requete sql(eloquent ORMo) pour compter le nombre de user à une date précise.
            $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
        }

    	return view('chartjs')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }
}
