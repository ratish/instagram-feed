<?php
namespace InstagramFeedApp;

class Curl
{
    public static function request($curlURL)
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        if(curl_error($ch)) {
            echo "CURL ERROR: " . curl_error($ch) . "<br>";
        }
        curl_close($ch);

        return json_decode($response);
    }
}
