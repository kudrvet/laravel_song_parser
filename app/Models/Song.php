<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Song
 *
 * @property int $id
 * @property int $soundcloud_id
 * @property int $artist_id
 * @property int $soundcloud_artist_id
 * @property int|null $comment_count
 * @property string $title
 * @property string $genre
 * @property string $kind
 * @property string $description
 * @property int $downloadable
 * @property int|null $download_count
 * @property int $duration
 * @property int $full_duration
 * @property string $embeddable_by
 * @property string|null $label_name
 * @property string|null $license
 * @property int|null $likes_count
 * @property string $permalink_url
 * @property int|null $playback_count
 * @property int $public
 * @property string $purchase_title
 * @property string $purchase_url
 * @property string|null $release_date
 * @property string|null $reposts_count
 * @property string $sharing
 * @property string|null $tag_list
 * @property string $track_format
 * @property string $uri
 * @property string $display_date
 *  * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Song newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Song newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Song query()
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereCommentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereDisplayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereDownloadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereEmbeddableBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereFullDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereKind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereLabelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song wherePermalinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song wherePlaybackCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song wherePurchaseTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song wherePurchaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereRepostsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereSharing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereSoundcloudArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereSoundcloudId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereTagList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereTrackFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereUri($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereUpdatedAt($value)
 */
class Song extends Model
{
    protected $table = 'media_tracks';
}
