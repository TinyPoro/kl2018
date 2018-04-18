<?php

namespace App\Console\Commands;

use App\Article;
use App\Word;
use Illuminate\Console\Command;

class TokTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:tok
    {--article=308 : article id to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test tokenizer and convert to VecOfVerb';

    private $input_folder = "vitk/input";
    private $output_folder = "vitk/output";
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

        $stop_file = fopen("vitk/stopwords.txt", "r") or die("Unable to open stop file!");

        $stop_word_arr = [];
        while(!feof($stop_file)) {
            $line = fgets($stop_file);
            $line=str_replace("\n","",$line);
            $stop_word_arr[] = $line;       //return word array
        }

        fclose($stop_file);

        $article = Article::find($article_id);

        $content = $article->content;

        $input_file = fopen("$this->input_folder/input.txt", "w") or die("Unable to open input file!");
        fwrite($input_file, $content);
        fclose($input_file);

        exec("vitk\\vnTokenizer.bat -i input/input.txt -o output/output.txt");

        $output_file = fopen("$this->output_folder/output.txt", "r") or die("Unable to open output file!");

        //chuyển thành vecto -> cập nhật được tf và df
        $inserted_word=[];
        while(!feof($output_file)) {
            $line = fgets($output_file);
            $word_arr = explode(" ", $line); //return word array
            foreach($word_arr as $w){
                $w = mb_strtolower($w, 'UTF-8');

                if($w == "") {
                    continue;
                }
                if(!in_array($w, $stop_word_arr)){
                    $word = Word::where('word', $w)->first();

                    if(!$word){
                        $word = new Word();
                        $word->word = $w;
                        $word->save();
                        $inserted_word[] = $w;

                        try{
                            \DB::table('article_word')->insert([
                                'article_id' => $article_id,
                                'word_id' => $word->id
                            ]);
                        }catch (\Exception $e){
                            echo $e->getMessage()."\n";
                        }

                    }else{
                        if(!in_array($w, $inserted_word)){
                            $word->df++;
                            $word->save();
                            $inserted_word[] = $w;

                            try{
                                \DB::table('article_word')->insert([
                                    'article_id' => $article_id,
                                    'word_id' => $word->id
                                ]);
                            }catch (\Exception $e){
                                echo $e->getMessage()."\n";
                            }

                        }else{
                            try{
                                \DB::table('article_word')
                                    ->where('article_id', $article_id)
                                    ->where('word_id', $word->id)
                                    ->increment('tf');
                            }catch (\Exception $e){
                                echo $e->getMessage()."\n";
                            }
                        }
                   }
                }
            }
        }

        fclose($output_file);
    }
}
