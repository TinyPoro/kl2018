<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;

class RunClassify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:classify';

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
        Article::where('host', 'dantri.com.vn')->where('type', 2)
            ->orderBy('id')->chunk(100, function ($articles){
                foreach ($articles as $article){
                    echo $article->id."\n";
                    \Artisan::call( 'test:classify', ['--article' => $article->id]);
                }
            });
    }
}
