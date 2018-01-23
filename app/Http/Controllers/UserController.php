<?php

namespace App\Http\Controllers;

use App\Article;
use function foo\func;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function keyword(){
        return view('User.keyword');
    }

    public function findkeyword(Request $request){
        $keyword = $request->get('keyword');

        $articles = Article::with('keywords')
            ->whereHas('keywords', function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%");
            })->get();

        return $articles;
    }

    public function info($id){
        $article = Article::find($id);

        return view('User.articleinfo', ['article'=>$article]);
    }
}
