<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
        return view('news.index', compact('news'));
    }

    public function category($slug)
    {
        $newsCategory = NewsCategory::where('slug', $slug)->firstOrFail();
        $news = News::where('news_category_id', $newsCategory->news_category_id)
            ->where('is_published', true)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('news.index', compact('newsCategory', 'news'));
    }

    public function show($slug)
    {
        $news_item = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        $recentNews = News::where('is_published', true)
            ->where('news_id', '!=', $news_item->news_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $relatedNews = News::where('news_category_id', $news_item->news_category_id)
            ->where('news_id', '!=', $news_item->news_id)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        return view('news.detail', compact('news_item', 'recentNews', 'relatedNews'));
    }
}
