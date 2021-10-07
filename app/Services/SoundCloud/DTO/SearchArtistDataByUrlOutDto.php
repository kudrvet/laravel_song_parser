<?php

namespace App\Services\SoundCloud\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class SearchArtistDataByUrlOutDto extends DataTransferObject
{
    #[MapFrom('id')]
    public int $soundcloud_id;
    public ?string $avatar_url;
    public string $city;
    public ?int $comments_count;
    public ?string $country_code;
    public ?string $description;
    public ?int $followers_count;
    public ?int $followings_count;
    public string $first_name;
    public string $full_name;
    public ?int $groups_count;
    public string $last_name;
    public ?int $likes_count;
    public ?int $playlist_likes_count;
    public string $permalink_url;
    public ?int $playlist_count;
    public ?int $reposts_count;
    public ?int $track_count;
    public string $username;
}
