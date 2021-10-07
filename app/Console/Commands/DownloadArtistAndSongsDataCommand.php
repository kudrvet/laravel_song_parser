<?php

namespace App\Console\Commands;

use App\Usecases\DownloadArtistAndSongsDataUsecase;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Throwable;

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
     * @param DownloadArtistAndSongsDataUsecase $usecase
     * @throws GuzzleException
     * @throws Throwable
     */
    public function handle(DownloadArtistAndSongsDataUsecase $usecase): void
    {
        $usecase->handle($this->argument('url'));
        $this->info('Library has been successfully downloaded!');
    }
}
