<?php

namespace App\PaymentGateway;

use App\Models\User;

class Zarinpal extends Payment
{
    public function send($amounts, $description, $addressId , $note ,$user_id , $date)
    {

        $user = User::find($user_id)->pluck('cashback');
        $data = array(
            'merchant_id' => '50cd8b2d-5350-4eb6-85c8-0adc04ff0bf8',
            'amount' => (int)round($amounts['paying_amount']) . '0',
            'callback_url' => route('home.payment.verify' , ['gatewayName' => 'zarinpal' ,'Authority' ,  'Status']),
            'description' => $description
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        if ($err) {
            return ['error' => "cURL Error #:" . $err];
        } else {
            if ($result['data']['code'] == 100) {

                $createOrder = parent::createOrder($addressId, $amounts, $result['data']["authority"], 'zarinpal' , $note , $date);
                if (array_key_exists('error', $createOrder)) {
                    return $createOrder;
                }

                return ['success' => 'https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]];
            } else {
                return ['error' => 'ERR: ' . $result['data']["code"]];
            }
        }
    }

    public function verify($authority, $amount)
    {
        $MerchantID = '50cd8b2d-5350-4eb6-85c8-0adc04ff0bf8';

        $data = array('merchant_id' => $MerchantID, 'authority' => $authority, 'amount' => (int)round($amount));
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            return ['error' => "cURL Error #:" . $err];
        } else {
           if(sizeof($result['data']))
            {
                 if ($result['data']['code'] == 100) {
                    $updateOrder = parent::updateOrder($authority, $result['data']['ref_id']);
                    if (array_key_exists('error', $updateOrder)) {
                        return $updateOrder;
                    }
                    \Cart::clear();
                    return ['success' => 'Transation success. RefID:' . $result['data']['ref_id']];
                }
            } else {
                 return redirect()->route('home.index');
            }
        }
    }
}
