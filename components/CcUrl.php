<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 27.05.2021
 * Time: 20:22
 */

namespace components;

use components\Debugger as d;

class CcUrl
{
    public $base_url;
    public $auth;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
//        $this->auth = $params['auth'];
    }

    public function request($endpoint = '', $options = [], $method){

        $api_endpoint = $this->base_url;
        $curl = curl_init();

        $headers = [
//            'Content-Type: application/json',
//            'Authorization: Basic '.$this->auth
        ];

        if(isset($options['headers']) AND count($options['headers'])){
            $headers = array_merge($headers,$options['headers']);
        }
//        d::pe($headers);
        if(count($headers)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        unset($options['url_items']);
        unset($options['headers']);

//        d::pe($options);

        if($method=='POST'){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($options));
        }else{
            if(count($options)){
                $api_endpoint .= '?'.http_build_query($options);
            }
        }

//        d::pe($api_endpoint);
//        d::tdfa($api_endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
        $response = curl_exec($curl);
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

//        d::pe($response);
        d::pe($http_status_code);

        if ($http_status_code==200){

            d::pe($response);

            $decoded = json_decode($response, true);
            $data = $decoded;
        } else {
            d::pe('Ошибка');
            $data = [];
            $data['error'] = $response;
        }
        return $data;

    }

}//Class