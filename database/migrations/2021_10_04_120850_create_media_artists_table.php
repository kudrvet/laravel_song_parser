<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'media_artists',
            function (Blueprint $table) {
                $table->id();
                $table->integer('soundcloud_id')->unique();
                $table->string('username')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('full_name');
                $table->text('description')->nullable();
                $table->string('city');
                $table->integer('comments_count')->nullable();
                $table->string('country_code')->nullable();
                $table->integer('followers_count')->nullable();
                $table->integer('followings_count')->nullable();
                $table->integer('groups_count')->nullable();
                $table->integer('track_count')->nullable();
                $table->integer('likes_count')->nullable();
                $table->integer('playlist_likes_count')->nullable();
                $table->integer('playlist_count')->nullable();
                $table->integer('reposts_count')->nullable();
                $table->string('permalink_url');
                $table->string('avatar')->nullable();
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
        Schema::dropIfExists('media_artists');
    }
}
