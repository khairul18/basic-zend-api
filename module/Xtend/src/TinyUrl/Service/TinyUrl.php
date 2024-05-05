<?php

namespace Xtend\TinyUrl\Service;

class TinyUrl
{
    const BASE_URL = 'http://tinyurl.com';

    /**
     * Shorten Url
     *
     * @param  string url
     * @return string short url
     */
    static function shorten(string $url)
    {
        $url = filter_var($url, FILTER_VALIDATE_URL);
        if ($url === false) {
            return false;
        }

        $curl = curl_init();
        $tinyUrlTarget = self::BASE_URL . '/api-create.php?' . http_build_query(['url' => $url]);
        curl_setopt_array($curl, [
          CURLOPT_URL => $tinyUrlTarget,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \RuntimeException("cURL Error #:" . $err);
        } else {
            return $response;
        }
    }
}
