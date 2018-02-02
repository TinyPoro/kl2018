<?php
/**
 * Created by PhpStorm.
 * User: ngoph
 * Date: 2/2/2018
 * Time: 10:20 AM
 */

namespace App\Crawler;


use App\Article;
use App\HostRule;
use Openbuildings\Spiderling\Driver_Phantomjs;
use Openbuildings\Spiderling\Driver_Phantomjs_Connection;
use Openbuildings\Spiderling\Page;

class PhantomCrawler
{
    private $date_pattern = '/\d+\/\d+\/\d+/u';
    private $id_pattern = '/(?<=-)\d+(?=\.htm)/ui';
    protected $page;

    public function __construct(){
    }

    public function run($article_id){
        $article = Article::find($article_id);
        if(!$article) $article = new Article();

        $host = $article->host;
        $url = $article->url;

        preg_match($this->id_pattern, $url, $id_matches);
        $id = $id_matches['0'];

        if(!$this->page){
            echo "tạo page mới\n";
            $phantomjs_driver_connection = new Driver_Phantomjs_Connection('http://localhost');
            $phantomjs_driver_connection->port(4445);
            $phantomjs_driver = new Driver_Phantomjs();
            $phantomjs_driver->connection($phantomjs_driver_connection);

            $this->page = new Page($phantomjs_driver);
        }

        try{
            $this->page->visit($url);
        }catch (\Exception $e){
            return;
        }

        //title
        try{
            $title = $this->page->find('title')->text();
        }catch (\Exception $ex){
            $title = null;
        }

        $article->title = $title;

        $rules = HostRule::where('host', $host)->first();

        //date
        $date_rules = json_decode($rules->date_rule, TRUE);
        $date_text = "";
        foreach ($date_rules as $date_rule) {
            list($type, $selector) = explode(": ", $date_rule, 2);

            if ($type == 'css') {

                try{
                    $date = $this->page->find($selector);

                    preg_match($this->date_pattern, $date->text(), $date_matches);
                    $date_text = $date_matches['0'];
                }catch (\Exception $ex){
                    $date_text = '13/07/1996';
                }
            }
        }

        $date_obj = \DateTime::createFromFormat('d/m/Y', $date_text);
        $article->date = $date_obj->format('Y-m-d');;

        //content
        $content_rules = json_decode($rules->content_rule, TRUE);
        $content_text = "";
        foreach ($content_rules as $content_rule) {
            list($type, $selector) = explode(": ", $content_rule, 2);

            if ($type == 'css') {
                try{
                    $contents = $this->page->all($selector);

                    foreach ($contents as $content) {
                        $content_text .= $content->text();
                    }
                }catch (\Exception $ex){
                    $content_text = "";
                }
            }
        }
        $article->content = $content_text;

        $article->save();

        //comment
        //        $comment_rules = json_decode($rules->comment_rule, TRUE);
        //        foreach ($comment_rules as $comment_rule){
        //            list($type, $selector) = explode(": ", $comment_rule, 2);
        //
        //            if($type == 'css-name'){
        //                $contents = $this->page->all($selector);
        //
        //                foreach ($contents as $content){
        //                    $comment = Comment::where('article_id', $article_id)
        //                        ->whereNull('user_name')
        //                        ->orderBy('id', 'asc')
        //                        ->first();
        //
        //                    $comment->user_name = $content->text();
        //                    $comment->save();
        //                }
        //            }
        //
        //            if($type == 'css-content'){
        //                Comment::where('article_id', $article_id)->delete();
        //                $contents = $this->page->all($selector);
        //
        //                foreach ($contents as $content){
        //                    $comment = new Comment();
        //                    $comment->article_id = $article_id;
        //                    $comment->content = $content->text();
        //                    $comment->save();
        //                }
        //            }
        //
        //            if($type == 'visit'){
        //                try{
        //                    $target = $this->page->find($selector);
        //                }
        //                catch (\Exception $e){
        //                    echo $e->getMessage()."\n";
        //                    break;
        //                }
        //
        //                $this->page->visit($target->attribute('src'));echo "visit $target->attribute('src')\n";
        //            }
        //
        //            if($type == 'visit_id'){
        //                $target_url = $selector. $id;
        //
        //                $this->page->visit($target_url); echo "visit $target_url\n";
        //            }
        //        }
    }
}