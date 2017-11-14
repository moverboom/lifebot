<?php
/**
 * Created by PhpStorm.
 * User: matthijs
 * Date: 14-11-17
 * Time: 20:07
 */

namespace AppBundle\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GuzzleWrapper
{
    private $allowedRequestTypes = array('GET', 'POST');

    public static $GET = 'GET';

    public static $POST = 'POST';

    /**
     * Execute HTTP request
     *
     * @param $type string request type (GET, POST)
     * @param $endpoint
     * @param array $data
     * @param array $headers
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function executeRequest($type, $endpoint, array $data = [], array $headers = [])
    {
        if(!in_array(strtoupper($type), $this->allowedRequestTypes)) {
            throw new \InvalidArgumentException(sprintf(
                "Request type should be one of %s but got %s",
                implode(", ", $this->allowedRequestTypes), $type
            ));
        }

        if(strtoupper($type) == 'GET' && !empty($data)) {
            $endpoint .= "?".implode("&", $data);
            $data = [];
        }

        $requestData = [
            'headers' => $headers,
            $data
        ];

        $client = new Client();

        try {
            return $client->request($type, $endpoint, $requestData);
        } catch (ClientException $exception) {
            var_dump($exception->getCode());
            return null;
            //TODO error handling
        }
    }
}