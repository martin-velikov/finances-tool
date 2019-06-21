<?php

namespace App\OpenExchangeRateApi;

class OpenExchange
{
    protected $app_id;

    public function __construct($app_id){
        $this->app_id = $app_id;
    }

    public function getRates(){
        $app_id = $this->app_id;
        $file = "latest.json";
        header("Content-Type: application/json");
        $json = file_get_contents("http://openexchangerates.org/api/{$file}?app_id={$app_id}");
        $obj = json_decode($json);
        $rate_container = array();

        if(isset($obj->{"rates"})){
            foreach($obj->{"rates"} as $currency=>$rate){
                $rate_container[$currency]=$rate;
            }
        }

        return $rate_container;
    }
}
