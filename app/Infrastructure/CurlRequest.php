<?php

declare(strict_types=1);

namespace App\Infrastructure;

class CurlRequest
{
    public function get(string $url, array $opts = null): ?string
    {
        if($opts === null) {
            $opts = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ];
        }

        $curl = curl_init();

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}