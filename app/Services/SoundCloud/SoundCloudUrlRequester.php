<?php

namespace App\Services\SoundCloud;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class SoundCloudUrlRequester
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new  Client();
    }

    /**
     * @param $url
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url): ResponseInterface
    {
        return  $this->client->request('GET', $url);
    }
}
