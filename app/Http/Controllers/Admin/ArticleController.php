<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('author_name', 'like', '%' . $request->author . '%');
        }

        // Filter by publish date range
        if ($request->filled('date_from')) {
            $query->whereDate('publish_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('publish_date', '<=', $request->date_to);
        }

        $articles = $query
            ->orderByDesc('publish_date')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Article::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.articles.index', [
            'articles' => $articles,
            'currentSearch' => $request->search,
            'currentStatus' => $request->status,
            'currentAuthor' => $request->author,
            'currentDateFrom' => $request->date_from,
            'currentDateTo' => $request->date_to,
            'categories' => $categories,
            'currentCategory' => $request->category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->validated();

        // Generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Article::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        // If status is published and publish_date is null, set to now
        if ($data['status'] === 'published' && empty($data['publish_date'])) {
            $data['publish_date'] = now();
        }

        $article = Article::create($data);

        return redirect()
            ->route('admin.articles.edit', $article)
            ->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', ['article' => $article]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        // Slug: if kosong, regenerate dari title. Jika diisi, akan divalidasi unique di ArticleRequest.
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug unique (ignore current article)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Article::where('slug', $data['slug'])
            ->where('id', '!=', $article->id)
            ->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        // Jika status published tapi publish_date kosong, isi sekarang
        if ($data['status'] === 'published' && empty($data['publish_date'])) {
            $data['publish_date'] = now();
        }

        $article->update($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Publish an article (set status to published and ensure publish_date).
     */
    public function publish(Article $article)
    {
        if ($article->status !== 'published') {
            if (!$article->publish_date || $article->publish_date->isFuture()) {
                $article->publish_date = now();
            }
            $article->status = 'published';
            $article->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Artikel berhasil dipublish.');
    }

    /**
     * Set an article back to draft status.
     */
    public function draft(Article $article)
    {
        if ($article->status !== 'draft') {
            $article->status = 'draft';
            $article->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Artikel berhasil diubah menjadi draft.');
    }
}

