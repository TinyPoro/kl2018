<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;

class ClassifyTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:classify
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

        $result['POSITIVE_RATE'] = 0;
        $result['NEGATIVE_RATE'] = 0;
        $result['NONE_RATE'] = 0;

        $article_count = Article::count();

        $POSITIVE_COUNT = Article::where('type', Article::POSITIVE_TYPE)->count();
        $NEGATIVE_COUNT = Article::where('type', Article::NEGATIVE_TYPE)->count();
        $NONE_COUNT = Article::where('type', Article::NONE_TYPE)->count();


        $P_POSITIVE = $POSITIVE_COUNT/$article_count;
        $P_NEGATIVE = $NEGATIVE_COUNT/$article_count;
        $P_NONE = $NONE_COUNT/$article_count;

        $result['POSITIVE_RATE'] -= log($P_POSITIVE);
        $result['NEGATIVE_RATE'] -= log($P_NEGATIVE);
        $result['NONE_RATE'] -= log($P_NONE);

        \DB::table('article_word')->where('article_id', $article_id)->orderBy('id')->chunk(100, function ($rows) use(&$result, $article_id, $POSITIVE_COUNT, $NEGATIVE_COUNT, $NONE_COUNT){
           foreach ($rows as $row){
               echo "a";
               $word_id = $row->word_id;
               $w = $row->w;

               $P_x_POSITIVE = Article::where('id', '<>', $article_id)
                   ->where('type', Article::POSITIVE_TYPE)
                   ->whereRaw("CAST((SELECT w FROM article_word WHERE article_word.article_id = articles.id and article_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

               $result['POSITIVE_RATE'] -= log(($P_x_POSITIVE+1)/($POSITIVE_COUNT+1));

               $P_x_NEGATIVE = Article::where('id', '<>', $article_id)
                   ->where('type', Article::NEGATIVE_TYPE)
                   ->whereRaw("CAST((SELECT w FROM article_word WHERE article_word.article_id = articles.id and article_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

               $result['NEGATIVE_RATE'] -= log(($P_x_NEGATIVE+1)/($NEGATIVE_COUNT+1));

               $P_x_NONE = Article::where('id', '<>', $article_id)
                   ->where('type', Article::NONE_TYPE)
                   ->whereRaw("CAST((SELECT w FROM article_word WHERE article_word.article_id = articles.id and article_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

               $result['NONE_RATE'] -= log(($P_x_NONE+1)/($NONE_COUNT+1));
           }
        });

        $max = max($result);
        $type = array_search($max, $result);

        if($type=="POSITIVE_RATE"){
            $article->type = 1;
        }

        if($type=="NEGATIVE_RATE"){
            echo "tieu cuc\n";
            $article->type = -1;
        }

        if($type=="NONE_RATE"){
            $article->type = 0;
        }
dump($result);
//        $article->save();
    }
}
