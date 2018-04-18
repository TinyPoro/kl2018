<?php

namespace App\Console\Commands;

use App\Word;
use Illuminate\Console\Command;

class CalWTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:calw';

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
        $n = \DB::table('article_word')->count();

        \DB::update("Update article_word set w = tf*log($n/(SELECT df from words where words.id = article_word.word_id))");
    }
}
