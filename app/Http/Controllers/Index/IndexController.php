<?php

namespace App\Http\Controllers\Index;

use App\Libraries\Config;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 首页控制器
class IndexController extends BaseController
{
    // 首页 文章列表
    public function index(Request $request)
    {
        // 文章列表
        $articles = Article::indexSearch($request);
        // 所有标签
        $tags = Tag::withCount('article')->orderBy('order', 'asc')->get();

        //return view('index.index.index', compact('articles', 'tags'));
        return 'index';
    }

    // 首页 归档导航
    public function archives(Request $request)
    {
        $list = Article::indexArchives($request);

        //return view('index.index.archives', compact('list'));
        return 'archives';
    }

    // 首页 文章详情
    public function archivesDetail(Request $request)
    {
        //
        return 'archive detail';
    }

    // 首页 页面详情
    public function pageDetail(Request $request)
    {
        //
        return 'page detail';
    }
}
