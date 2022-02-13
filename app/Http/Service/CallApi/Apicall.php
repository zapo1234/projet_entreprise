<?php
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;

class Apicall
{
   /** 
   *@return array
   */
   public function getData(string $url): array
   {
       $response = Http::get($url);
       return $response->json();
   }

  public function getWocommerce(string $url,string $apikey, string $apikes, string $data)
  {
        // getdata api rest woocommerce 
        //apikey customer keys , apikeys clé secret
          $woocommerce = new Client(
          $url,
          $apikey,
          $apikeys,
        [
         'wp_api'=> true,
         'version' => 'wc/v3',
         'query_string_auth' => true
        ]
     );
        // renvoi les données en json
        $data = $woocommerce->get($data);
        return $data;
  }

  public function getDataDolibar(string $apikey,string $url): array
  {
     // recupération des données de l'api dolibar
     $curl = curl_init();
     $httploader = ['DOLAPIKEY: '.$apikey];
     
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
     $result = curl_exec($curl);
     curl_close($curl);
     // transformer en array les données
     $data = json_decode($result,true);
     return $data;

  }

   /** 
   *@return array
   */
   public function getDataJson(): array
   {
     $file = public_path() . "/Upload/project.json";
     // renvoi le fichier sous forme de chaine de caractères
     $data = file_get_contents($file);
     // renvoi les données sous formes de tableau(array)
     $data = json_decode($data,true);
     return $data;
   }

   /** 
   *@return array
   */
  public function getDataJson1(): array
  {
    $file = public_path() . "/Upload/project1.json";
    // renvoi le fichier sous forme de chaine de caractères
    $data = file_get_contents($file);
    // renvoi les données sous formes de tableau(array)
    $data = json_decode($data,true);
    return $data;
  }

}



