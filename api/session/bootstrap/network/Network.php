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



    public function upload(string $URL, $postData)
    {
        try {
            $response = $this->client->request('POST', $URL, [
                'multipart' => [
                    [
                        'name' => 'subject_id',
                        'contents' => $postData['subject_id'],
                    ],
                    [
                        'name' => 'module_id',
                        'contents' => $postData['module_id'],
                    ],
                    [
                        'name' => 'title',
                        'contents' => $postData['title'],
                    ],
                    [
                        'name' => 'description',
                        'contents' => $postData['description'],
                    ],
                    [
                        'name'     => 'file',
                        'contents' => fopen($postData['file']['tmp_name'], 'r'),
                        'filename' => $postData['file']['name']
                    ]

                ],
                'headers'  => [
                    'Authorization' =>  'Bearer ' . $this->session->getToken(),
                    'debug' => false,
                ]
            ]);
//            echo $response->getStatusCode(); // 200
            $data = \GuzzleHttp\json_decode($response->getBody());
            return $data;

        } catch (RequestException $e) {
            echo Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\Message::toString($e->getResponse());
            }
        }
    }

}