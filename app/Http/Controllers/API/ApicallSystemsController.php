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
       $apiKey = "4LAI7pNFl3oM7znLc8II9tB7xu7o2r7C";
       $apiUrl = "http://localhost/dolibarr/htdocs/api/index.php/";
       //appelle de la fonction  Api
      // $data = $this->api->getDatadolibar($apikey,$url);
      // domp affichage test
       
      //Recuperer les ref et id product dans un tableau
	   
	    $produitParam = ["limit" => 10000, "sortfield" => "rowid"];
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
      
       $list_id_order[] = $val1['ref_client'];// recupérer les id commande  oders de woocomerce
    }

    $array_donnees = array_unique($list_id_order);// recupérer les ref client qui devient id commande de dolibar
    
    
     $list_tier = json_decode($list_tiers,true);
   
     // recupérer les email existant dans tiers
     $data_email = [];
     $data_list = []; //tableau associative de id et email
    
     $data_code =[];// tableau associative entre id(socid et le code client )
     
     
     foreach($list_tier as $val)
     {
        $data_email[$val['code_client']] = $val['email'];
        $data_list[$val['id']] = $val['email'];
         
        // recuperer id customer du client et créer un tableau associative.
        $code_cl = explode('-',$val['code_client']);
        $code_cls = $code_cl[2];
        $data_code[$val['id']] = $code_cls;
        
     }
     
     // recuperer dans un tableau les ref_client existant id.
   $clientSearch = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "DESC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);

   // recupérer le dernière id des facture 
   // recuperer dans un tableau les ref_client existant id.
   $invoices_id = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "DESC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);

   // recupération du dernier id invoices dolibar
   foreach($invoices_id as $vk)
   {
      $inv = $vk['id'];
   }
   
   foreach($clientSearch as $data)
   {
        $tiers_ref = $data['id'];
   }
     
   // convertir en entier la valeur.
     $id_cl = (int)$tiers_ref;
      $id_cl = $id_cl+1;
      $socid ="";
      // id  du dernier invoices(facture)
      $inv = (int)$inv;
     $inv = $inv +1;
     // recupérer  les données dans un tableau associative(id et ref_article) dans dolibar
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
        $woo ="woocommerce";
        $name="";
        $code = $donnees['customer_id'];//customer_id dans woocomerce
        $code_client ="WC-AN2022-$code";// recupérer le customer id dans wocoomerce
        $data_tiers[] =[ 

                 'entity' =>'1',
                 'name'=> $donnees['billing']['last_name'],
                 'name_alias' => $woo,
                 'email' => $donnees['billing']['email'],
                 'phone' => $donnees['billing']['phone'],
                 'client' 	=> '1',
                'code_client'	=> $code_client
        ];
           
   
      }
       
      // recupére les lines d'artilce liée achété du client 
      $list_refs =[];
      // recupérer tous les id product et leur quantité
      $list_product_stocks =[];
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
               
               // recupérer le tableau pour les stocks mouvement
                $list_product_stocks[] =[
                  $values['product_id']=>$values['quantity']
                ];
         }    // recupérer les champs dolibar utile pour les articles liée dans la facture
              // si la commande existe deja avec un id 
              // recupérer les socid en fonction de leur article lié
              
                      if(!in_array($donnees['id'], $array_donnees))
                       {
                         $d=1;
                         $data_lines[] = [
                         'socid'=> $socid,
                         'ref_int' =>$d,
                        'ref_client' =>$donnees['id'],// fournir un id orders wocommerce dans dolibar.
                         "email" => $donnees['billing']['email'],
                          "total_ht"  =>floatval($donnees['total']),
                         'total_tva' =>floatval($donnees['total_tax']),
                          "total_ttc" =>floatval($donnees['total']),
                          'lines' =>$data_product,
                         ];
                   }
         }

         
        // renvoyer un tableau unique par id commande
       $temp = array_unique(array_column($data_lines, 'socid'));
       $unique_arr = array_intersect_key($data_lines, $temp);
      
        // verifier suprimer  les socid différent du ref_ext dans le listing product associé
       foreach($unique_arr as $r => $val)
        {
           
         foreach($val['lines'] as $q => $vak)
           {
             if($val['socid']!=$vak['ref_ext'])
             {
                 unset($unique_arr[$r]['lines'][$q]);
             }

            }
         }
       
   
      // insérer data tiers dans dolibar.
       foreach($data_tiers as $data){
       // insérer les données tiers dans dolibar
         $this->api->CallAPI("POST", $apiKey, $apiUrl."thirdparties", json_encode($data));
       
      }
       // recupérer les lines details article de commande de la facture
      //insert dans dolibar listing atrticle commande
       // insérer data tiers dans dolibar.
       // verifie si le id orders de woocomerce existante deja
        //foreach($unique_arr as $donnes)
        // {
        //     // insérer les données invoices dans dolibar
         //     $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices", json_encode($donnes));
         
        // }
      
        // valider invoice
        $newCommandeValider = [
         "idwarehouse"	=> "0",
         "notrigger"		=> "0"
         ];
      
           foreach($unique_arr as $donnes)
           {
              // insérer les données invoices dans dolibar en brouillon
              // valider les facture en boucle
              $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices", json_encode($donnes));
            
           }
           
          //valider les factures entrées
           $nbrs = count($unique_arr)+$inv;

            for($i=$inv; $i<$nbrs; $i++)
            {
               $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices/".$i."/validate", json_encode($newCommandeValider));
         
            }
            $mode ="pre";
            $newCommandepaye = [
               "paye"	=> 1,
               "statut"	=> 2,
               "mode_reglement" => $mode
               ];
            // passer les factures validé  en mode payant
            //statut =2 et paye =2;// faire une modification
            for($i=$inv; $i<$nbrs; $i++)
            {
               $this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/".$i, json_encode($newCommandepaye));
         
            }

            // gerer les stocks mouvemts de mise à jours à partir des id product et quantité.

         // fixer moyens de paiement mode de reglement sur les facture
         $newValues = [
            "paiementid" => 1,
            "closepaidinvoices" => "yes",
            "accountid"=> 1,
         
         ];
         
         // liee le paimeent à un compte bancaire.
         for($i=$inv; $i<$nbrs; $i++)
         {
          $this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/payments/".$i."", json_encode($newValues));
      
         }
       
        dd('succes of opération');
       // initialiser un array recuperer les ref client.
        
        
         return view('apidolibar');
   }


    
    public function invoicespay()
    {
      // recuperer les données api dolibar.
       $method = "GET";
       $apiKey = "4LAI7pNFl3oM7znLc8II9tB7xu7o2r7C";
       $apiUrl = "http://localhost/dolibarr/htdocs/api/index.php/";
       //appelle de la fonction  Api
      // $data = $this->api->getDatadolibar($apikey,$url);
      // domp affichage test

      // recupérer le dernière id des facture 
   // recuperer dans un tableau les ref_client existant id.
   $invoices_id = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "DESC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);


   // recupérer le premier id de la facture

 // recuperer dans un tableau les ref_client existant id.
   $invoices_asc = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "ASC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);
    
     // recuperer dans un tableau les ref_client existant id.
     $clientSearch = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		"sortfield" => "t.rowid", 
		"sortorder" => "DESC", 
		"limit" => "1", 
		"mode" => "1",
		)
	), true);


   // recupération du dernier id invoices dolibar
   foreach($invoices_id as $vk)
   {
      $inv = $vk['id'];
   }

   // recupérer le premier id de la facture
   foreach($invoices_asc as $vks)
   {
      $inc = $vks['id'];
   }
   

   
   foreach($clientSearch as $data)
   {
        $tiers_ref = $data['id'];
   }
     
   // convertir en entier la valeur.
     $id_cl = (int)$tiers_ref;
      $id_cl = $id_cl+1;
      $socid ="";
      // id  du dernier invoices(facture)
      $inv = (int)$inv;
     $inv = $inv +1;
     

     $list_id_order = [];
     $produitParam = ["limit" => 10000, "sortfield" => "rowid"];
     $listorders_id = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
     //
     $list_id = json_decode($listorders_id,true);
     $nombre = count($list_id);
      
     // valider invoice
     $newCommandeValider = [
      "idwarehouse"	=> "0",
      "notrigger"		=> "0",
      ];
    
     $newCommandepaye = [
      "paye"	=> 1,
      "statut"	=> 2,
      ];
   // passer les factures validé  en mode payant
   //statut =2 et paye =2;// faire une modification

      for($i=$inc; $i<$inv+1; $i++)
      {
        $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices/".$i."/validate", json_encode($newCommandeValider));
        
      }

      for($i=$inc; $i<$inv+1; $i++)
      {
        $this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/".$i, json_encode($newCommandepaye));
      }

      
      //$this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/".$a, json_encode($newCommandepaye));
       
    }

    
    
    

}

