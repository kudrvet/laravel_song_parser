<?php

namespace App\Services\SoundCloud\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class GetSongsByArtistIdOutDto extends DataTransferObject
{
    #[MapFrom('id')]
    public int $soundcloud_id;
    public ?string $artwork_url;
    public ?int $comment_count;
    public ?string $description;
    public bool $downloadable;
    public ?int $download_count;
    public int $duration;
    public int $full_duration;
    public string $embeddable_by;
    public string $genre;
    public string $kind;
    public ?string $label_name;
    public ?string $license;
    public ?int $likes_count;
    public string $permalink_url;
    public ?int $playback_count;
    public bool $public;
    public ?string $purchase_title;
    public ?string $purchase_url;
    public ?string $release_date;
    public ?int $reposts_count;
    public string $sharing;
    public ?string $tag_list;
    public string $title;
    public string $track_format;
    public string $uri;
    #[MapFrom('user_id')]
    public int $soundcloud_artist_id;
    public string $display_date;
}
