<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Env;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function getSnapToken()
    {
        $username = Env::get('SNAP_PAY_USERNAME');
        $password = Env::get('SNAP_PAY_PASSWORD');
        $client_id = Env::get('SNAP_PAY_CLIENT_ID');
        $client_secret = Env::get('SNAP_PAY_CLIENT_SECRET');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/v1/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&scope=online-merchant&username=' . $username . '&password=' . $password,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ". base64_encode($client_id . ':' . $client_secret),
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);

    }
}
