<?php

class DataService
{
    private string $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getData(): string
    {
        $curl = curl_init();

        // set request options
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // execute request
        $resp = curl_exec($curl);

        // check if something went wrong & close session
        $errorNo = curl_errno($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($errorNo) {
            throw new Exception("Couldn't send request - curl error no: " . $errorNo);
        } elseif (200 != $httpStatus) {
            throw new Exception("Request failed - HTTP status code: " . $httpStatus);
        }

        return $resp;
    }
}