<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'media_tracks',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('artist_id')->references('id')->on('media_artists');
                $table->integer('soundcloud_id')->unique();
                $table->integer('soundcloud_artist_id');
                $table->integer('comment_count')->nullable();
                $table->string('title');
                $table->string('genre');
                $table->string('kind');
                $table->text('description')->nullable();
                $table->boolean('downloadable');
                $table->integer('download_count')->nullable();
                $table->integer('duration');
                $table->integer('full_duration');
                $table->string('embeddable_by');
                $table->string('label_name')->nullable();
                $table->string('license')->nullable();
                $table->integer('likes_count')->nullable();
                $table->string('permalink_url');
                $table->integer('playback_count')->nullable();
                $table->boolean('public');
                $table->string('purchase_title')->nullable();
                $table->string('purchase_url')->nullable();
                $table->string('release_date')->nullable();
                $table->string('reposts_count')->nullable();
                $table->string('sharing');
                $table->string('tag_list')->nullable();
                $table->string('track_format');
                $table->string('uri');
                $table->string('display_date');
                $table->timestamps();

            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_tracks');
    }
}
