<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Show list of published articles.
     */
    public function index(Request $request)
    {
        $query = Article::published();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $articles = $query
            ->orderByDesc('publish_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Article::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('customer.articles.index', [
            'pageTitle' => 'Artikel',
            'pageDescription' => 'Kumpulan artikel edukasi, tips, dan informasi dari ' . config('app.name'),
            'articles' => $articles,
            'categories' => $categories,
            'currentSearch' => $request->search,
            'currentCategory' => $request->category,
        ]);
    }

    /**
     * Show single article by slug.
     */
    public function show(Article $article)
    {
        // Pastikan aturan publikasi terpenuhi
        if ($article->status !== 'published' || !$article->publish_date || $article->publish_date->isFuture()) {
            abort(404);
        }

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->orderByDesc('publish_date')
            ->limit(4)
            ->get();

        return view('customer.articles.show', [
            'pageTitle' => $article->title,
            'pageDescription' => $article->excerpt ?: $article->title,
            'article' => $article,
            'relatedArticles' => $related,
        ]);
    }
}

