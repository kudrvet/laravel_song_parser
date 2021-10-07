<?php

namespace App\Usecases;

use App\Models\Artist;
use App\Models\Song;
use App\Services\SoundCloud\DTO\GetSongsByArtistIdOutDto;
use App\Services\SoundCloud\DTO\SearchArtistDataByUrlOutDto;
use App\Services\SoundCloud\SoundCloudService;
use App\Services\SoundCloud\SoundCloudUrlRequester;
use Illuminate\Support\Facades\Storage;

class DownloadArtistAndSongsDataUsecase
{

    public function __construct(
        private SoundCloudService $soundCloudService,
        private SoundCloudUrlRequester $urlRequester
    ) {}

    /**
     * @param string $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function handle(string $url): void
    {
        $artistDTO = $this->soundCloudService->searchArtistDataByUrl($url);

        $artist = $this->saveArtistData($artistDTO);

        if ($artistDTO->avatar_url) {
            $avatarFile = (string)$this->urlRequester
                ->get($artistDTO->avatar_url)
                ->getBody();
            $avatarName = "{$artist->id}.jpg";
            $artist->avatar = $avatarName;
            $artist->save();

            Storage::disk('local')->put("avatars/{$avatarName}", $avatarFile);
        }


        $songsDTO = $this->soundCloudService->getSongsByArtistId($artist->soundcloud_id);

        $this->saveSongsData($artist->id, $songsDTO);
    }

    /**
     * @param SearchArtistDataByUrlOutDto $dto
     * @return Artist
     * @throws \Throwable
     */
    private function saveArtistData(SearchArtistDataByUrlOutDto $dto): Artist
    {
        $artist = Artist::whereSoundcloudId($dto->soundcloud_id)->first();
        if (!$artist) {
            $artist = new Artist();
        }

        $artist->soundcloud_id = $dto->soundcloud_id;
        $artist->username = $dto->username;
        $artist->first_name = $dto->first_name;
        $artist->last_name = $dto->last_name;
        $artist->full_name = $dto->full_name;
        $artist->description = $dto->description;
        $artist->city = $dto->city;
        $artist->comments_count = $dto->comments_count;
        $artist->country_code = $dto->country_code;
        $artist->followers_count = $dto->followers_count;
        $artist->followings_count = $dto->followings_count;
        $artist->groups_count = $dto->groups_count;
        $artist->track_count = $dto->track_count;
        $artist->likes_count = $dto->likes_count;
        $artist->playlist_likes_count = $dto->playlist_likes_count;
        $artist->playlist_count = $dto->playlist_count;
        $artist->reposts_count = $dto->reposts_count;
        $artist->permalink_url = $dto->permalink_url;

        $artist->saveOrFail();

        return $artist;
    }

    /**
     * @param int $artistId
     * @param GetSongsByArtistIdOutDto[] $songDtos
     * @throws \Throwable
     */
    private function saveSongsData(int $artistId, array $songDtos): void
    {
        foreach ($songDtos as $dto) {
            $song = Song::whereSoundcloudId($dto->soundcloud_id)->first();
            if (!$song) {
                $song = new Song();
            }
            $song->artist_id = $artistId;
            $song->soundcloud_id = $dto->soundcloud_id;
            $song->soundcloud_artist_id = $dto->soundcloud_artist_id;
            $song->comment_count = $dto->comment_count;
            $song->title = $dto->title;
            $song->genre = $dto->genre;
            $song->kind = $dto->kind;
            $song->description = $dto->description;
            $song->downloadable = $dto->downloadable;
            $song->download_count = $dto->download_count;
            $song->duration = $dto->duration;
            $song->full_duration = $dto->full_duration;
            $song->embeddable_by = $dto->embeddable_by;
            $song->label_name = $dto->label_name;
            $song->license = $dto->license;
            $song->likes_count = $dto->likes_count;
            $song->permalink_url = $dto->permalink_url;
            $song->playback_count = $dto->playback_count;
            $song->public = $dto->public;
            $song->purchase_title = $dto->purchase_title;
            $song->purchase_url = $dto->purchase_url;
            $song->release_date = $dto->release_date;
            $song->reposts_count = $dto->reposts_count;
            $song->sharing = $dto->sharing;
            $song->tag_list = $dto->tag_list;
            $song->track_format = $dto->track_format;
            $song->uri = $dto->uri;
            $song->display_date = $dto->display_date;

            $song->saveOrFail();
        }
    }
}
