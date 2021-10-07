<?php

namespace Tests\Unit;

use App\Services\SoundCloud\DTO\GetSongsByArtistIdOutDto;
use App\Services\SoundCloud\DTO\SearchArtistDataByUrlOutDto;
use App\Services\SoundCloud\SoundCloudService;
use App\Services\SoundCloud\SoundCloudUrlRequester;
use App\Usecases\DownloadArtistAndSongsDataUsecase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadArtistAndSongsDataUsecaseTest extends TestCase
{

    private SoundCloudService $soundCloudService;
    private DownloadArtistAndSongsDataUsecase $usecase;
    private SoundCloudUrlRequester $urlRequester;

    protected function setUp(): void
    {
        parent::setUp();
        $this->soundCloudService = $this->createMock(SoundCloudService::class);
        $this->urlRequester = $this->createMock(SoundCloudUrlRequester::class);
        $this->usecase = new DownloadArtistAndSongsDataUsecase($this->soundCloudService, $this->urlRequester);
    }

    public function testHandle()
    {
        $this->assertDatabaseCount('media_artists', 0);
        $this->assertDatabaseCount('media_tracks', 0);

        $artistDto = $this->getArtstDto();
        $this->soundCloudService->method('searchArtistDataByUrl')
            ->willReturn($artistDto);

        $this->soundCloudService->method('getSongsByArtistId')
            ->willReturn($this->getSongsDto());

        $fixtureFileName = 'fakeAvatar.jpg';
        $fullPathToFixture = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Fixtures', $fixtureFileName]));
        $fakeJpg = file_get_contents($fullPathToFixture);

        Storage::fake('local');

        $this->urlRequester->method('get')
            ->willReturn(new Response(200, [], $fakeJpg));

        $this->usecase->handle('https://testUrl.com');

        $this->assertDatabaseCount('media_artists', 1);
        $this->assertDatabaseCount('media_tracks', 2);

        $artistId = DB::table('media_artists')
            ->select('id')
            ->where('soundcloud_id', '=', $artistDto->soundcloud_id)
            ->first()
            ->id;

        Storage::disk('local')
            ->assertExists("avatars/{$artistId}.jpg");
    }

    private function getArtstDto()
    {
        return  new SearchArtistDataByUrlOutDto(
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
    }

    private function getSongsDto()
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
            public: true,
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
            public: true,
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
}