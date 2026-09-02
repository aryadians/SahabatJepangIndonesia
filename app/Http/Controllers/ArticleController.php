<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Halaman Publik Daftar Artikel Edukasi & Berita
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $query = Article::where('is_published', true)->latest();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = Article::where('is_published', true)->distinct()->pluck('category');

        return view('articles.index', compact('articles', 'categories', 'settings'));
    }

    /**
     * Halaman Publik Detail Baca Artikel
     */
    public function show($slug)
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $article->increment('views');

        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest()
            ->take(3)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = Article::where('is_published', true)
                ->where('id', '!=', $article->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('articles.show', compact('article', 'relatedArticles', 'settings'));
    }
}
