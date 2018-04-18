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
        $articles = Article::where('host', 'dantri.com.vn')->get();
        foreach ($articles as $article){
            $a = \DB::table('article_word')
                ->where('article_id', $article->id)->get();
            if(count($a) == 0){
                echo $article->id."\n";
                \Artisan::call( 'test:tok', ['--article' => $article->id]);
            }
        }
    }
}
