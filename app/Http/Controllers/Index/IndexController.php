<?php

namespace App\Http\Controllers\Index;

use App\Libraries\Config;
use App\Models\Article;
use App\Models\Page;
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

        return view('index.index.index', compact('articles', 'tags'));
    }

    // 首页 归档导航
    public function archives(Request $request)
    {
        $list = Article::indexArchives($request);

        return view('index.index.archives', compact('list'));
    }

    // 首页 文章详情
    public function archivesDetail(Request $request,$id)
    {
        $info = Article::frontendDetail($id);
        if ($info === false) {
            abort(404);
        }
        return view('index.index.archives-detail',compact('info'));
    }

    // 首页 页面详情
    public function pageDetail(Request $request,$id)
    {
        $info = Page::frontendDetail($id);
        if ($info === false) {
            abort(404);
        }
        return view('index.index.page-detail',compact('info'));
    }
}
