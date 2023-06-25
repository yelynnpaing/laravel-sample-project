<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'detail');
    }

    public function index() {

        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id) {

        $article = Article::find($id);

        return view('articles.detail', [
            'article' => $article
        ]);

    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "Web"],
            ["id" => 2, "name" => "Mobile"],
            ["id" => 3, "name" => "Network"],
            ["id" => 4, "name" => "Cloud"],
        ];

        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(),[
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if(Gate::allows('delete-article', $article)) {
            $article->delete();
            return redirect('/articles')->with('info', 'Article delete complete');
        }
        return back()->with('info', 'Unauthorize to delete');
    }

    public function edit($id)
    {
        $article = Article::find($id);

        $data = [
            ["id" => 1, "name" => "Web"],
            ["id" => 2, "name" => "Mobile"],
            ["id" => 3, "name" => "Network"],
            ["id" => 4, "name" => "Cloud"],
        ];

        return view('articles.edit', [
            'categories' => $data,
            'article' => $article,
        ]);
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()) {
            return back();
        }

        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();

        return view('articles.detail', [
             'article' => $article
        ]);
    }


}
