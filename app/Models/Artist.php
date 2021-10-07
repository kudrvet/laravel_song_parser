<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property int $soundcloud_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string|null $description
 * @property string $city
 * @property int|null $comments_count
 * @property int $country_code
 * @property int|null $followers_count
 * @property int|null $followings_count
 * @property int|null $groups_count
 * @property int|null $track_count
 * @property int|null $likes_count
 * @property int|null $playlist_likes_count
 * @property int|null $playlist_count
 * @property int|null $reposts_count
 * @property string $permalink_url
 * @property string $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereFollowingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereGroupsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist wherePermalinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist wherePlaylistCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist wherePlaylistLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereRepostsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereSoundcloudId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereTrackCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUsername($value)
 * @mixin \Eloquent
 */
class Artist extends Model
{
    protected $table = 'media_artists';
}
