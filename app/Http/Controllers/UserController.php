<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\DiaryActivity;
use App\Report\ReportManager;
use App\Summary\Summarizer;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function keyword(){
        return view('User.keyword');
    }

    public function findkeyword(Request $request){
        $user = Auth::user();

        $keyword = $request->get('keyword');
        ReportManager::saveReport($user->id, DiaryActivity::Find_Keyword, "$user->name tìm kiếm từ khóa $keyword");

        $articles = Article::with('keywords')
            ->whereHas('keywords', function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%");
            })->get();

        return $articles;
    }

    public function article_info($id){
        $article = Article::find($id);

        $comments = $article->comments;

        return view('User.articleinfo', ['article'=>$article, 'comments'=>$comments]);
    }

    public function chart(Request $request){
        $keyword = $request->get('keyword');

        $articles = Article::with('keywords')
            ->whereHas('keywords', function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%");
            });

        $host_result =[];
        $_articles = clone $articles;
        $hosts = $_articles->select('host')->distinct()->get();

        foreach($hosts as $host) {
            $_articles = clone $articles;
            $host_count = $_articles->where('host', $host->host)->count();
            $array = [];
            $array['label'] = $host->host;
            $array['y'] = $host_count;

            $host_result[] = $array;
        }

        $date_result = [];
        $_articles = clone $articles;
        $dates = $_articles->selectRaw("DATE_FORMAT(date,'%Y-%m') as new_date")->distinct()->get();

        foreach($dates as $date) {
            $_articles = clone $articles;
            $date_count = $_articles->where('date', 'like', "$date->new_date%")->count();
            $array = [];
            $array['label'] = $date->new_date;
            $array['y'] = $date_count;

            $date_result[] = $array;
        }

        $result = [];
        $result['host'] = $host_result;
        $result['date'] = $date_result;

        return $result;
    }

    public function classify(Request $request) {
        $keyword = $request->get('keyword');

        $articles = Article::with('keywords')
            ->whereHas('keywords', function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%");
            });

        $result=[];

        $articles_result=[];
        $_articles = clone $articles;
        $articles_positive_count = $_articles->where('type', Article::POSITIVE_TYPE)->count();
        $articles_result['positive'] = $articles_positive_count;
        $_articles = clone $articles;
        $articles_none_count = $_articles->where('type', Article::NONE_TYPE)->count();
        $articles_result['none'] = $articles_none_count;
        $_articles = clone $articles;
        $articles_negative_count = $_articles->where('type', Article::NEGATIVE_TYPE)->count();
        $articles_result['negative'] = $articles_negative_count;
        $result['articles'] = $articles_result;

        $comments_result=[];
        $comments_result['positive'] = 0;
        $comments_result['none'] = 0;
        $comments_result['negative'] = 0;

        $comments = [];

        foreach ($articles->get() as $article) {
            foreach ($article->comments as $comment){
                if($comment->type == Article::NEGATIVE_TYPE) $comments_result['negative']++;
                if($comment->type == Article::NONE_TYPE) $comments_result['none']++;
                if($comment->type == Article::POSITIVE_TYPE) $comments_result['positive']++;
            }
        }

        $result['comments'] = $comments_result;

        return $result;
    }

    public function info($id = null){
        $user = Auth::user();

        if($id) {  //xem người khác
            $target_user = User::find($id);

            if($user->type<User::SUPER_ADMIN_TYPE && $user->type <= $target_user->type) {
                return redirect('/');
            }else return view('User.info', ['user'=>$target_user]);
        }
        else return view('User.info', ['user'=>$user]); //tự xem bản thân
    }

    public function update(Request $request){
        $cur_user = Auth::user();

        $user = User::find($request->get('id'));

        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->department = $request->get('department');
        $user->position = $request->get('position');
        $user->address = $request->get('address');

        $saved = $user->save();

        ReportManager::saveReport($cur_user->id, DiaryActivity::Update_Information, "$cur_user->name cập nhật thông tin của $user->id");


        if($saved) return view('User.info', ['user'=>$user]);
        else return redirect('/');
    }

    public function summary_show(){
        return view('User.summary');
    }

    public function summary(Request $request){
        $user = Auth::user();
        $content = $request->get('content');

        ReportManager::saveReport($user->id, DiaryActivity::Single_Summarizing, "$user->name tóm tắt đơn văn bản");


        $summarizer = new Summarizer();
        return $summarizer->get_summary_n($content, 0.5);
    }
}
