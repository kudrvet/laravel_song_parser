<?php

namespace App\Services\SoundCloud;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class SoundCloudApiRequester
{
    private string $baseSongsUrl = 'https://api-v2.soundcloud.com/users/';
    private ClientInterface $client;
    private array $params;

    public function __construct(array $params = null, ClientInterface $client = null)
    {
        $this->params = $params ?: $this->getDefaultParams();

        if (!isset($this->params['client_id']) || !isset($this->params['limit']) ) {
            throw new \Exception("'client_id' and 'limit' params must be declared");
        }
        $this->client = $client ?: new Client();
    }

    /**
     * @param int $artistId
     * @param array $addedQueryParams
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $artistId, array $addedQueryParams = []): ResponseInterface
    {
        $url = "{$this->baseSongsUrl}{$artistId}/tracks";
        $options = [
            'query'   => $this->params + $addedQueryParams
        ];
        return $this->client->request('GET', $url, $options);
    }

    /**
     * @return array
     */
    private function getDefaultParams(): array
    {
       return Config::get('soundcloud');
    }
}
