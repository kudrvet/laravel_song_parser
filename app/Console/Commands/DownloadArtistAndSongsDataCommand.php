<?php

namespace App\Console\Commands;

use App\Services\SoundCloud\SoundCloudApiRequester;
use App\Services\SoundCloud\SoundCloudService;
use App\Usecases\DownloadArtistAndSongsDataUsecase;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadArtistAndSongsDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'soundcloud:load {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command download artist info and songs data via soundcloud profile url';

    /**
     * Create a new command instance.
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
    public function handle(DownloadArtistAndSongsDataUsecase $usecase)
    {
        $usecase->handle($this->argument('url'));
        $this->info('Library has been successfully downloaded!');
    }
}
