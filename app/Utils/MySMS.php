<?php

namespace App\Utils;

class MySMS {

    public static function sendSMS($phone, $message) {
        $APIKey="EB35E086A6EAFF5BA8E281FD8203F1";
        $SecretKey="7F27F2C0EB292CF18A3006E7A303DD";
        $YourPhone="01647942877";
        ini_set('max_execution_time', 300);
        $ch = curl_init();


        $SampleXml = "<RQST>"
           . "<APIKEY>". $APIKey ."</APIKEY>"
           . "<SECRETKEY>". $SecretKey ."</SECRETKEY>"
           . "<ISFLASH>0</ISFLASH>"
           . "<SMSTYPE>7</SMSTYPE>"
           . "<CONTENT>". $message ."</CONTENT>"
           . "<CONTACTS>"
           . "<CUSTOMER>"
           . "<PHONE>". $phone ."</PHONE>"
           . "</CUSTOMER>"
           . "</CONTACTS>"
           . "</RQST>";


        curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/SendMultipleMessage_V4/" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

        $result=curl_exec ($ch);

        if($result)	{
            $xml = simplexml_load_string($result);

            if ($xml === false) {
                return -1;
            }

            //now we can loop through the xml structure
            //Tham khao them ve SMSTYPE de gui tin nhan hien thi ten cong ty hay gui bang dau so 8755... tai day :http://esms.vn/SMSApi/ApiSendSMSNormal

            return $xml->CodeResult;

        }
    }
}
