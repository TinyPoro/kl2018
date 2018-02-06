<?php

namespace App\Console\Commands;

use App\Article;
use App\Crawler\PhantomCrawler;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RunTok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:tok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $crawler;
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
     * @return mixed
     */
    public function handle()
    {


        $process = new Process('phantomjs phantom.js 4445 phantomjs-connection.js --ssl-protocol=any --ignore-ssl-errors=true');
        echo "x";
        $process->run();
        echo "a";

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        dd("a");
        $this->crawler = new PhantomCrawler();
        $articles = Article::where('host', 'dantri.com.vn')->get();
        foreach ($articles as $article){
            echo $article->id."\n";
            $this->crawler->run($article->id);
        }
    }
}
