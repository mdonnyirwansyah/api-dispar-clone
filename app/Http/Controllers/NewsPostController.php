<?php

namespace App\Http\Controllers;

use App\DataTables\NewsPostDataTable;
use App\Http\Resources\NewsPostResource;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class NewsPostController extends Controller
{
    // WEB
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
        $tags = Tag::all();

        return view('app.news.posts.create', compact('newsCategories', 'tags'));
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
            $newsPost->status = $request->status;
            $newsPost->slug = Str::slug($request->title);
            $newsPost->save();

            if ($request->tags) {
                $newsPost->tags()->sync($request->tags);
            }

            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(NewsPost $newsPost)
    {
        $newsCategories = NewsCategory::all();
        $tags = Tag::all();

        return view('app.news.posts.edit', compact('newsCategories', 'tags', 'newsPost'));
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
        if (Gate::allows('is-editor')) {
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

            if ($request->title_en || $request->content_en ) {
                if ($newsPost->editor_id) {
                    $editor = $newsPost->editor_id;
                } else {
                    $editor = Auth::user()->id;
                }
            } else {
                $editor = null;
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
                $newsPost->status = $request->status;
                $newsPost->slug = Str::slug($request->title);
                $newsPost->save();

                if ($request->tags) {
                    $newsPost->tags()->sync($request->tags);
                }

                return response()->json(['success' => 'Record has been updated!']);
            }

            return response()->json(['error' => $validator->errors()]);
        } else {
            $newsPost->status = $request->status;
            $newsPost->save();

            return response()->json(['success' => 'Record has been updated!']);
        }
    }

    public function destroy(NewsPost $newsPost)
    {
        if ($newsPost->thumbnail) {
            Storage::delete($newsPost->thumbnail);
        }
        $newsPost->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }

    public function destroyChecked(Request $request)
    {
        $newsPosts = NewsPost::whereIn('id', $request->rowChecked);
        foreach ($newsPosts as $newsPost) {
            if ($newsPost->thumbnail) {
                Storage::delete($newsPost->thumbnail);
            }
        }
        $newsPosts->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }

    // API
    public function get(Request $request)
    {
        $currentPage = $request->current_page ?? 1;
        $perPage = $request->per_page ?? 5;
        $total = NewsPost::where('status', 'Published')->count();
        $newsPosts = NewsPost::where('status', 'Published')->orderBy('published_at', 'DESC')->limit(intval($perPage))->offset((intval($currentPage) - 1) * intval($perPage))->get();

        $response = [
            'message' => 'List of news post order by published',
            'data' => NewsPostResource::collection($newsPosts),
            'current_page' => intval($currentPage),
            'per_page' => intval($perPage),
            'total' => $total
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $newsPost = NewsPost::where('slug', $slug)->where('status', 'Published')->first();

        if ($newsPost) {
            $viewer = $newsPost->viewer + 1;

            $newsPost->viewer = $viewer;
            $newsPost->save();

            $response = [
                'message' => 'Detail of news post resource',
                'data' => new NewsPostResource($newsPost)
            ];

            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Object not found!',
            ];

            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
