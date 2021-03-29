<?php

namespace session;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use session\config\Constants;

class Network
{

    private \UserSession $session;

    private Client $client;

    public function __construct(\UserSession $session, $BASE_URL = Constants::API_URL)
    {
        $this->session = $session;
        $this->client = new Client(
            [
                'base_uri' => $BASE_URL,
                'timeout' => 0
            ]
        );
    }

    public function invoke(string $URL, string $METHOD, $JSON = null)
    {
        try {
            $response = $this->client->request(
                $METHOD,
                $URL,
                [
                    'headers' =>
                        ['Authorization' => 'Bearer ' . $this->session->getToken(),],
                    'debug' => true,
                    'json' => $JSON
                ],
            );
//            echo $response->getStatusCode(); // 200
            $data = \GuzzleHttp\json_decode($response->getBody());
            return $data->data;

        } catch (RequestException $e) {
            echo Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\Message::toString($e->getResponse());
            }
        }
    }

}