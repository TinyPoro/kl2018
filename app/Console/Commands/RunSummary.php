<?php

namespace App\Console\Commands;

use App\Article;
use App\Summary\Summarizer;
use Illuminate\Console\Command;

class RunSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:summary 
    {--article=308 : article id to run}';

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
     * @return mixed
     */
    public function handle()
    {
        $article_id = $this->option('article');
        $article = Article::find($article_id);

        $content = $article->content;

        $summarizer = new Summarizer();
        echo $summarizer->get_summary_n($content, 0.5);
    }
}
