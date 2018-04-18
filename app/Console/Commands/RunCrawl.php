<?php

namespace App\Console\Commands;

use App\Article;
use App\Crawler\PhantomCrawler;
use Illuminate\Console\Command;

class RunCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:crawl';

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

    private $crawler;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->crawler = new PhantomCrawler();
        $articles = Article::where('type', '<>', 0)->where('host', 'dantri.com.vn')->get();
        foreach ($articles as $article){
            echo $article->id."\n";
            $this->crawler->run($article->id);
        }
    }
}
