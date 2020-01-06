<?php
namespace App\Http\Controllers;


use Ipsum\Article\app\Models\Categorie;
use Ipsum\Article\app\Models\Article;


class ArticleController extends Controller
{

    public function index($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();


         return view('article.show', compact('article'));
    }


    public function blogIndex()
    {
        $page = Article::where('nom', 'Accueil')->firstOrFail();
        $articles = Article::posts()->with('illustration')->publie()->orderBy('created_at', 'desc')->paginate(21);

        return view('article.blog.liste', compact('page', 'articles'));
    }

    public function blogDetail($slug)
    {
        $article = Article::posts()->publie()->where('slug', $slug)->firstOrFail();

        return view('article.blog.show', compact('article'));
    }


    public function home()
    {
        $article = Article::where('nom', 'Accueil')->firstOrFail();

        return view('home', compact('article'));
    }

}