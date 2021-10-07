<?php

namespace App\Console\Commands;

use App\Services\SoundCloud\SoundCloudApiRequester;
use App\Services\SoundCloud\SoundCloudService;
use App\Services\SoundCloud\SoundCloudUrlRequester;
use App\Usecases\DownloadArtistAndSongsDataUsecase;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SoundCloudService $service, SoundCloudApiRequester $apiRequester, DownloadArtistAndSongsDataUsecase $usecase, SoundCloudUrlRequester $urlRequester)
    {

        $urls = [
            'https://soundcloud.com/birocratic',
            'https://soundcloud.com/lakeyinspired',
            'https://soundcloud.com/aljoshakonstanty',
            'https://soundcloud.com/dixxy-2',
            'https://soundcloud.com/dekobe'
            ];
        foreach ($urls as $url) {
             $usecase->handle($url);
        }
//        $url = 'https://soundcloud.com/dekobe';
//        $dto = $service->searchArtistDataByUrl($url);
//        $avatarUrl = $dto->avatar_url;
//        dump($avatarUrl);
//        $file = (string) $urlRequester->get($avatarUrl)->getBody();
//        Storage::put("avatars/{$dto->soundcloud_id}.jpg",$file);

//        dd($file);
    }
}
