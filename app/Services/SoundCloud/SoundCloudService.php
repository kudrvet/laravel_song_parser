<?php

namespace App\Services\SoundCloud;

use App\Services\SoundCloud\DTO\GetSongsByArtistIdOutDto;
use App\Services\SoundCloud\DTO\SearchArtistDataByUrlOutDto;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SoundCloudService
{
    private SoundCloudUrlRequester $urlRequester;
    private SoundCloudApiRequester $apiRequster;

    public function __construct(SoundCloudUrlRequester $urlRequester, SoundCloudApiRequester $apiRequester)
    {
        $this->urlRequester = $urlRequester;
        $this->apiRequster = $apiRequester;
    }

    /**
     * @param string $profileUrl
     * @return SearchArtistDataByUrlOutDto
     * @throws GuzzleException
     * @throws UnknownProperties
     * @throws Exception
     */
    public function searchArtistDataByUrl(string $profileUrl): SearchArtistDataByUrlOutDto
    {
        $html = (string)$this->urlRequester->get($profileUrl)->getBody();

        $inner = strstr($html, '{"hydratable":"user"');
        if ($inner == false) {
            throw new  Exception('Soundcloud response structure has changed!');
        }

        $data = explode("];</script>", $inner);

        if (count($data) < 2) {
            throw new  Exception('Soundcloud response structure has changed!');
        }

        $userDataInJson = $data[0];

        $userData = json_decode($userDataInJson, true);
        if ($userData === null) {
            throw new Exception('Soundcloud response structure has changed!');
        }

        return isset($userData['data']) ? new SearchArtistDataByUrlOutDto($userData['data']) :
            throw new Exception('Soundcloud response structure has changed!');
    }

    /**
     * @param $artistId
     * @return GetSongsByArtistIdOutDto[]
     * @throws UnknownProperties|GuzzleException
     * @throws Exception
     * @throws Exception
     * @throws Exception
     */
    public function getSongsByArtistId($artistId): array
    {
        $response = $this->apiRequster->get($artistId);

        $data = $this->decodeJsonResponse((string)$response->getBody());

        if (!isset($data['collection'])) {
            throw new Exception('Soundcloud response structure has changed!');
        }
        $values = $data['collection'];
        $linkWithRestData = $data['next_href'] ?? null;

        if ($linkWithRestData) {
            $restValues = $this->loadRestValues($artistId, $linkWithRestData);
            $allValues = array_merge($values, $restValues);
        } else {
            $allValues = $values;
        }

        return  array_map(fn($songData) => new GetSongsByArtistIdOutDto($songData), $allValues);
    }

    /**
     * @param $artistId
     * @param $link
     * @return array
     * @throws Exception
     * @throws GuzzleException
     */
    private function loadRestValues($artistId, $link): array
    {
        $restValues = [];
        while ($link) {
            $query = parse_url($link, PHP_URL_QUERY);
            parse_str($query, $queryParams);

            if (!isset($queryParams['offset'])) {
                throw new Exception('Soundcloud response structure has changed!');
            }
            $offset = $queryParams['offset'];

            $response = $this->apiRequster->get($artistId, ['offset' => $offset]);
            $data = $this->decodeJsonResponse((string)$response->getBody());

            if (!isset($data['collection'])) {
                throw new Exception('Soundcloud response structure has changed!');
            }

            $nextValues = $data['collection'];
            $restValues[] = $nextValues;
            $link = $data['next_href'] ?? null;
        }

        return Arr::flatten($restValues, 1);
    }

    /**
     * @param string $string
     * @return array
     * @throws Exception
     */
    private function decodeJsonResponse(string $string): array
    {
        $data = json_decode($string, true);
        if ($data === null) {
            throw new Exception('json response expected from soundcloud');
        }
        return $data;
    }
}
