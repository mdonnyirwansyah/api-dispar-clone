<?php

namespace App\Http\Controllers;

use App\DataTables\NewsPostDataTable;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsPostController extends Controller
{
    public function index(NewsPostDataTable $dataTable)
    {
        return $dataTable->render('app.news.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newsCategories = NewsCategory::all();
        $newsTags = NewsTag::all();

        return view('app.news.posts.create', compact('newsCategories', 'newsTags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:news_posts',
            'category' => 'required',
            'content' => 'required',
            'source' => 'required',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $newsPost = new NewsPost();
            $newsPost->title = $request->title;
            $newsPost->news_category_id = $request->category;
            $newsPost->content = $request->content;
            $newsPost->source = $request->source;
            $newsPost->author_id = Auth::user()->id;
            $newsPost->thumbnail = $request->file('thumbnail')->store('images/news');
            $newsPost->slug = Str::slug($request->title);
            $newsPost->save();

            if ($request->tags) {
                $newsPost->newsTags()->sync($request->tags);
            }

            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(NewsPost $newsPost)
    {
        $newsCategories = NewsCategory::all();
        $newsTags = NewsTag::all();

        return view('app.news.posts.edit', compact('newsCategories', 'newsTags', 'newsPost'));
    }

    public function update(Request $request, NewsPost $newsPost)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:news_posts,title,' .$newsPost->id,
            'category' => 'required',
            'content' => 'required',
            'source' => 'required',
            'thumbnail' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->file('thumbnail')) {
            if ($newsPost->thumbnail) {
                Storage::delete($newsPost->thumbnail);
            }
            $thumbnail = $request->file('thumbnail')->store('images/news');
        } elseif ($newsPost->thumbnail) {
            $thumbnail = $newsPost->thumbnail;
        } else {
            $thumbnail = null;
        }

        if ($newsPost->editor_id) {
            $editor = $newsPost->editor_id;
        } else {
            $editor = Auth::user()->id;
        }

        if ($validator->passes()) {
            $newsPost->title = $request->title;
            $newsPost->title_en = $request->title_en;
            $newsPost->news_category_id = $request->category;
            $newsPost->content = $request->content;
            $newsPost->content_en = $request->content_en;
            $newsPost->source = $request->source;
            $newsPost->editor_id = $editor;
            $newsPost->thumbnail = $thumbnail;
            $newsPost->slug = Str::slug($request->title);
            $newsPost->save();

            if ($request->tags) {
                $newsPost->newsTags()->sync($request->tags);
            }

            return response()->json(['success' => 'Record has been updated!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(NewsPost $newsPost)
    {
        $newsPost->delete();
        if ($newsPost->thumbnail) {
            Storage::delete($newsPost->thumbnail);
        }
        return response()->json(['success' => 'Record has been deleted!']);
    }
}
