<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

class NewsController extends Controller
{
    public function getItems(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $news = News::orderBy('date', 'desc')
        ->where('display', 1)
        ->orderBy('id', 'desc')
        ->select(['id', 'title', 'cover_img', 'date', 'summary'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = News::count();
        
        return response()->json([
            'news' => $news,
            'total' => $total,
        ]);
    }

    public function getItem($id, Request $request) {
        $new = News::find($id);

        return response()->json([
            'new' => $new
        ]);
    }
}