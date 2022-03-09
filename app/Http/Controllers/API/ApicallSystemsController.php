<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\CallApi\Apicall;

use Illuminate\Http\Request;

class ApicallSystemsController extends Controller
{

   private $api;

   public function __construct(Apicall $api)
   {
      $this->api = $api;
   }
   
    public function index()
   {
      
      //data elyamaje

    
    
    // recuperer les données api dolibar.
       $method = "GET";
       $apiKey = "wH5YU4soGdBq2y7VHy3Xn24iI3q02oQZ";
       $apiUrl = "http://localhost/dolibarr/htdocs/api/index.php/";
       //appelle de la fonction  Api
      // $data = $this->api->getDatadolibar($apikey,$url);
      // domp affichage test
       
      //Recuperer les ref et id product dans un tableau
	   
	    $produitParam = ["limit" => 100, "sortfield" => "rowid"];
	     $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);

      
      // reference ref_client dans dolibar
      //Recuperer les ref_client existant dans dolibar
	   $tiers_ref = "";
      $produitParam = ["limit" => 10000, "sortfield" => "rowid"];
     $list_tiers = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", $produitParam);
     // recupérer dans un array les valeurs

    // verifier attribue ref_client dans dolibar comme id commande woocomerce!
     //Recuperer les ref_client existant dans dolibar
     //verifié l'unicité
     $list_id_order = [];
     $produitParam = ["limit" => 10000, "sortfield" => "rowid"];
     $listorders_id = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
     //
     $list_id = json_decode($listorders_id,true);
     
    // recupérer dans un array les valeurs
    foreach($list_id as $val1)
    {
       $list_id_order[] = $val1['ref_client'];// recupérer les oders
    }

    $array_donnees = array_unique($list_id_order);
    
    
     $list_tier = json_decode($list_tiers,true);
     // recupérer les email existant dans tiers
     $data_email = [];
     $data_list = []; //tableau associative de id et email
     foreach($list_tier as $val)
     {
        $data_email[$val['code_client']] = $val['email'];
        $data_list[$val['id']] = $val['email'];
     }
     
     // recuperer dans un tableau les ref_client existant id.
   $clientSearch = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "DESC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);
   
   foreach($clientSearch as $data)
   {
        $tiers_ref = $data['id'];
   }
     
   // convertir en entier la valeur.
     $id_cl = (int)$tiers_ref;
      $id_cl = $id_cl+1;
      $socid ="";
     // recupérer  les données dans un tableau associative(id et ref_article) dans dloibar
	   $listproduct = json_decode($listproduct, true);
      foreach($listproduct as $values)
      {
         $product_data[$values['id']]= $values['ref'];
         
     }
      
     // recupére les customer des données provenant de  woocomerce
     // appel du service via api
     $customer = $this->api->getDataJson();
     //initialiser un array
     

     $data_tiers = [];//data tiers dans dolibar
     $data_lines  = [];// data article liée à commande du tiers en cours
     $data_product =[]; // data article details sur commande facture
     $data = [];
     $lines =[];
     foreach($customer as  $donnees)
     {
        // recupérer les données pour les tiers pour dolibar post tiers dans l'array
        // recupérer les données article liée à la comande 
        $ref_client = rand(4,10);
        //verifié et recupérer id keys existant de l'article
        $fk_tiers = array_search($donnees['billing']['email'],$data_list);
        if($fk_tiers!="")
        {
           $socid = $fk_tiers;
        }
        else{
        $socid = $id_cl++;
        $data_tiers[] =[ 

                 'entity' =>'1',
                 'name'=> $donnees['billing']['last_name'],
                 'email' => $donnees['billing']['email'],
                 'phone' => $donnees['billing']['phone'],
                 'client' 	=> '1',
                'code_client'	=> '-1'
        ];
           
   
      }
       
      // recupére les line d'artilce liée achété du client 
      $list_refs =[];
      foreach($donnees['line_items'] as $key => $values)
      {
         //verifié et recupérer id keys existant de l'article
               $fk_product = array_search($values['product_id'],$product_data);
              // details  array article libéllé(product sur la commande) pour dolibar
                $data_product[] = [
                  "multicurrency_subprice"=> floatval($values['subtotal']),
                  "multicurrency_total_ht" => floatval($values['subtotal']),
                  "multicurrency_total_tva" => floatval($values['total_tax']),
                  "multicurrency_total_ttc" => floatval($values['total']),
                   "product_ref" => $values['product_id'],
                   "product_label" =>$values['name'],
                   "qty" => $values['quantity'],
                   "fk_product" => $fk_product,
                   "ref_ext" => $socid,
               ];
               
 
         }    // recupérer les champs dolibar utile pour les articles liée dans la facture
              // si la commande existe deja avec un id 
              // recupérer les socid en fonction de leur article lié

              foreach($data_product as $keys => $valu)
              {
                   
                     if($valu['ref_ext']== $socid)
                     {
              
                      if(!in_array($donnees['id'], $array_donnees))
                       {
                         $data_lines[] = [
                         "socid"=> $socid,
                        "ref_client" =>$donnees['id'],// fournir un id orders wocommerce dans dolibar.
                         "email" => $donnees['billing']['email'],
                          "total_ht"  =>floatval($donnees['total']),
                         "total_tva" =>floatval($donnees['total_tax']),
                          "total_ttc" =>floatval($donnees['total']),
                          "lines" =>$data_product,
                         ];
                   }
              }    
         }
     }
        // renvoyer un tableau unique par id commande
       $temp = array_unique(array_column($data_lines, 'socid'));
       $unique_arr = array_intersect_key($data_lines, $temp);
      
      // insérer data tiers dans dolibar.
       foreach($data_tiers as $data){
       // insérer les données tiers dans dolibar
       $newClientResult = $this->api->CallAPI("POST", $apiKey, $apiUrl."thirdparties", json_encode($data));
       
      }
       // recupérer les lines details article de commande de la facture
      //insert dans dolibar listing atrticle commande
       // insérer data tiers dans dolibar.
       // verifie si le id orders de woocomerce existante deja
      
         foreach($unique_arr as $donnes)
         {
            // insérer les données tiers dans dolibar
            $newClientResults = $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices", json_encode($donnes));
             
         }
      
    
       
        dd('succes of opération');
       // initialiser un array recuperer les ref client.
        
        
         return view('apidolibar');
   }




}