<?php

namespace Tests\Unit;

use App\Services\SoundCloud\DTO\GetSongsByArtistIdOutDto;
use App\Services\SoundCloud\DTO\SearchArtistDataByUrlOutDto;
use App\Services\SoundCloud\SoundCloudApiRequester;
use App\Services\SoundCloud\SoundCloudService;
use App\Services\SoundCloud\SoundCloudUrlRequester;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class SoundCloudServiceTest extends TestCase
{
    private $urlRequesterStub;
    private $apiRequesterStub;
    private $soundCloudService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlRequesterStub = $this->createMock(SoundCloudUrlRequester::class);
        $this->apiRequesterStub = $this->createMock(SoundCloudApiRequester::class);
        $this->soundCloudService = new SoundCloudService($this->urlRequesterStub, $this->apiRequesterStub);
    }

    public function testSearchArtistDataByUrl()
    {
        $fixtureFileName = 'artistPage.html';
        $fullPathToFixture = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Fixtures', $fixtureFileName]));
        $fakeHtml = file_get_contents($fullPathToFixture);

        $this->urlRequesterStub->method('get')->willReturn(new Response(200, [], $fakeHtml));

        $artistDTO = $this->soundCloudService->searchArtistDataByUrl('url');
        $expectedDTO = new SearchArtistDataByUrlOutDto(
            avatar_url: "https://i1.sndcdn.com/avatars-XnK6LzSfwz2yczAB-DYlUxQ-large.jpg",
            city: "Mississauga",
            comments_count: 282,
            country_code: "CA",
            description: "Software Developer & Beatmaker\n\nprofile picture done by https://www.instagram.com/francois_section/ show him some love!!",
            followers_count: 8734,
            followings_count: 242,
            first_name: "Julian",
            full_name: "Julian Saavedra",
            groups_count: 0,
            id: 102429008,
            last_name: "Saavedra",
            likes_count: 228,
            playlist_likes_count: 5,
            permalink_url: "https://soundcloud.com/dekobe",
            playlist_count: 5,
            reposts_count: null,
            track_count: 66,
            username: "DeKobe",
        );

        $this->assertEquals($artistDTO, $expectedDTO);
    }

    public function testGetSongsByArtistIdWhenResponseWithoutNextLinks()
    {
        $fixtureFileName = 'songs.json';
        $fullPathToFixture = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Fixtures', $fixtureFileName]));
        $fakeJson = file_get_contents($fullPathToFixture);

        $this->apiRequesterStub->method('get')
            ->willReturn(new Response(200, [], $fakeJson));

        $songsDto = $this->soundCloudService->getSongsByArtistId(11111);
        $expectedSongsDto = $this->getExpectedSongsDto();

        $this->assertEquals($expectedSongsDto, $songsDto);
    }

    public function testGetSongsByArtistIdWhenResponseWithNextLinks()
    {
        $responseDataWithNextLinksFileName = 'songsWithNextData.json';
        $responseDataWithOutNextLinksFileName = 'songs.json';

        $fakeJsonWithNextLinks = file_get_contents($this->getFixturePath($responseDataWithNextLinksFileName));
        $fakeJsonWithOutNextLinks = file_get_contents($this->getFixturePath($responseDataWithOutNextLinksFileName));

        $artistId = 11111;
        $addedParams  = ['offset' => $this->getOffsetFromNextLink($fakeJsonWithNextLinks)];

        $returnMap =
            [
                [$artistId,  [], new Response(200, [], $fakeJsonWithNextLinks)],
                [$artistId, $addedParams, new Response(200, [], $fakeJsonWithOutNextLinks)]
            ];


        $this->apiRequesterStub->method('get')
            ->will($this->returnValueMap($returnMap));

        $songsDto = $this->soundCloudService->getSongsByArtistId($artistId);

        $expectedSongsDto = $this->getExpectedSongsWithNextLinks();

        $this->assertEquals($expectedSongsDto, $songsDto);
    }

    private function getFixturePath($filename)
    {
        return realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Fixtures', $filename]));
    }

    private function getOffsetFromNextLink(string $json)
    {
        $data = json_decode($json, true);

        if (!isset($data['next_href'])) {
            throw new \Exception(" 'next_href' key should exist in \$data ");
        }

        $link = $data['next_href'];
        $query = parse_url($link, PHP_URL_QUERY);
        parse_str($query, $queryParams);

        if (!isset($queryParams['offset'])) {
            throw new \Exception('offset query param  should exist in link!');
        }

        return $queryParams['offset'];
    }
    private function getExpectedSongsDto()
    {
        $dto1 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-H3TDzGaDKMEJIyYC-6RaKqA-large.jpg",
            caption: null,
            comment_count: 18,
            created_at: "2020-12-24T18:08:13Z",
            description: "hopefully not the last upload for the year.\n\ni wish you all happy holidays!!!",
            downloadable: false,
            download_count: 0,
            duration: 240065,
            full_duration: 240065,
            embeddable_by: "all",
            genre: "Beats",
            id: 953607133,
            kind: "track",
            label_name: null,
            license: "cc-by",
            likes_count: 208,
            permalink_url: "https://soundcloud.com/dekobe/besame",
            playback_count: 6580,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 14,
            sharing: "public",
            tag_list: "Vanilla Beats \"Instrumental Hip Hop\" \"Boom Bap\" \"Jazz Hip Hop\" ChillHop Nujabes \"J Dilla\" Boombap HipHop \"Hip Hop\" Dreamhop",
            title: "Besame",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/953607133",
            user_id: 102429008,
            display_date: "2020-12-24T18:11:12Z",
        );

        $dto2 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-hycJexna7yrPNKJV-wxfzww-large.jpg",
            caption: null,
            comment_count: 25,
            created_at: "2020-11-15T04:35:50Z",
            description: "",
            downloadable: false,
            download_count: 0,
            duration: 187899,
            full_duration: 187899,
            embeddable_by: "all",
            genre: "Beats",
            id: 929520847,
            kind: "track",
            label_name: null,
            license: "cc-by-sa",
            likes_count: 259,
            permalink_url: "https://soundcloud.com/dekobe/dindi",
            playback_count: 8149,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 34,
            sharing: "public",
            tag_list: "Nujabes Vanilla \"Instrumental Hip Hop\" DeKobe Beats",
            title: "Dindi",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/929520847",
            user_id: 102429008,
            display_date: "2020-11-15T04:41:41Z",
        );

        return [$dto1, $dto2];
    }

    private function getExpectedSongsWithNextLinks()
    {
        $dto1 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-H3TDzGaDKMEJIyYC-6RaKqA-large.jpg",
            caption: null,
            comment_count: 18,
            created_at: "2020-12-24T18:08:13Z",
            description: "description",
            downloadable: false,
            download_count: 0,
            duration: 240065,
            full_duration: 240065,
            embeddable_by: "all",
            genre: "Beats",
            id: 222222,
            kind: "track",
            label_name: null,
            license: "cc-by",
            likes_count: 208,
            permalink_url: "https://soundcloud.com/dekobe/besame",
            playback_count: 6580,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 14,
            sharing: "public",
            tag_list: "tag1",
            title: "Sunrise",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/953607133",
            user_id: 102429008,
            display_date: "2020-12-24T18:11:12Z",
        );

        $dto2 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-hycJexna7yrPNKJV-wxfzww-large.jpg",
            caption: null,
            comment_count: 25,
            created_at: "2020-11-15T04:35:50Z",
            description: "",
            downloadable: false,
            download_count: 0,
            duration: 187899,
            full_duration: 187899,
            embeddable_by: "all",
            genre: "Beats",
            id: 33333333,
            kind: "track",
            label_name: null,
            license: "cc-by-sa",
            likes_count: 259,
            permalink_url: "https://soundcloud.com/dekobe/dindi",
            playback_count: 8149,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 34,
            sharing: "public",
            tag_list: "Rap",
            title: "Dog",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/929520847",
            user_id: 102429008,
            display_date: "2020-11-15T04:41:41Z",
        );

        $dto3 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-H3TDzGaDKMEJIyYC-6RaKqA-large.jpg",
            caption: null,
            comment_count: 18,
            created_at: "2020-12-24T18:08:13Z",
            description: "hopefully not the last upload for the year.\n\ni wish you all happy holidays!!!",
            downloadable: false,
            download_count: 0,
            duration: 240065,
            full_duration: 240065,
            embeddable_by: "all",
            genre: "Beats",
            id: 953607133,
            kind: "track",
            label_name: null,
            license: "cc-by",
            likes_count: 208,
            permalink_url: "https://soundcloud.com/dekobe/besame",
            playback_count: 6580,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 14,
            sharing: "public",
            tag_list: "Vanilla Beats \"Instrumental Hip Hop\" \"Boom Bap\" \"Jazz Hip Hop\" ChillHop Nujabes \"J Dilla\" Boombap HipHop \"Hip Hop\" Dreamhop",
            title: "Besame",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/953607133",
            user_id: 102429008,
            display_date: "2020-12-24T18:11:12Z",
        );

        $dto4 = new GetSongsByArtistIdOutDto(
            artwork_url: "https://i1.sndcdn.com/artworks-hycJexna7yrPNKJV-wxfzww-large.jpg",
            caption: null,
            comment_count: 25,
            created_at: "2020-11-15T04:35:50Z",
            description: "",
            downloadable: false,
            download_count: 0,
            duration: 187899,
            full_duration: 187899,
            embeddable_by: "all",
            genre: "Beats",
            id: 929520847,
            kind: "track",
            label_name: null,
            license: "cc-by-sa",
            likes_count: 259,
            permalink_url: "https://soundcloud.com/dekobe/dindi",
            playback_count: 8149,
            public : true,
            purchase_title: null,
            purchase_url: null,
            release_date: null,
            reposts_count: 34,
            sharing: "public",
            tag_list: "Nujabes Vanilla \"Instrumental Hip Hop\" DeKobe Beats",
            title: "Dindi",
            track_format: "single-track",
            uri: "https://api.soundcloud.com/tracks/929520847",
            user_id: 102429008,
            display_date: "2020-11-15T04:41:41Z",
        );

        return [$dto1, $dto2, $dto3, $dto4];
    }
}
