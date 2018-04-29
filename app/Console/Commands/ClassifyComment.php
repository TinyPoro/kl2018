<?php

namespace App\Console\Commands;

use App\Comment;
use Illuminate\Console\Command;

class ClassifyComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:classify
    {--comment=308 : comment id to run}';

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
        $comment_id = $this->option('comment');
        $comment = Comment::find($comment_id);

        $result['POSITIVE_RATE'] = 0;
        $result['NEGATIVE_RATE'] = 0;
        $result['NONE_RATE'] = 0;

        $comment_count = Comment::count();

        $POSITIVE_COUNT = Comment::where('type', Comment::POSITIVE_TYPE)->count();
        $NEGATIVE_COUNT = Comment::where('type', Comment::NEGATIVE_TYPE)->count();
        $NONE_COUNT = Comment::where('type', Comment::NONE_TYPE)->count();


        $P_POSITIVE = $POSITIVE_COUNT/$comment_count;
        $P_NEGATIVE = $NEGATIVE_COUNT/$comment_count;
        $P_NONE = $NONE_COUNT/$comment_count;

        $result['POSITIVE_RATE'] -= log($P_POSITIVE);
        $result['NEGATIVE_RATE'] -= log($P_NEGATIVE);
        $result['NONE_RATE'] -= log($P_NONE);

        \DB::table('comment_word')->where('comment_id', $comment_id)->orderBy('id')->chunk(100, function ($rows) use(&$result, $comment_id, $POSITIVE_COUNT, $NEGATIVE_COUNT, $NONE_COUNT){
            foreach ($rows as $row){
                $word_id = $row->word_id;
                $w = $row->w;

                $P_x_POSITIVE = Comment::where('id', '<>', $comment_id)
                    ->where('type', Comment::POSITIVE_TYPE)
                    ->whereRaw("CAST((SELECT w FROM comment_word WHERE comment_word.comment_id = comments.id and comment_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

                $result['POSITIVE_RATE'] -= log(($P_x_POSITIVE+1)/($POSITIVE_COUNT+1));

                $P_x_NEGATIVE = Comment::where('id', '<>', $comment_id)
                    ->where('type', Comment::NEGATIVE_TYPE)
                    ->whereRaw("CAST((SELECT w FROM comment_word WHERE comment_word.comment_id = comments.id and comment_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

                $result['NEGATIVE_RATE'] -= log(($P_x_NEGATIVE+1)/($NEGATIVE_COUNT+1));

                $P_x_NONE = Comment::where('id', '<>', $comment_id)
                    ->where('type', Comment::NONE_TYPE)
                    ->whereRaw("CAST((SELECT w FROM comment_word WHERE comment_word.comment_id = comments.id and comment_word.word_id = $word_id) AS DECIMAL) = CAST($w AS DECIMAL)")->count();

                $result['NONE_RATE'] -= log(($P_x_NONE+1)/($NONE_COUNT+1));
            }
        });

        $max = max($result);
        $type = array_search($max, $result);

        if($type=="POSITIVE_RATE"){
            $comment->type = 1;
        }

        if($type=="NEGATIVE_RATE"){
            $comment->type = -1;
        }

        if($type=="NONE_RATE"){
            $comment->type = 0;
        }

        $comment->save();
    }
}
