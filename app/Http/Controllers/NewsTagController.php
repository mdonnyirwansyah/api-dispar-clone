<?php

namespace App\Http\Controllers;

use App\DataTables\NewsTagDataTable;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NewsTagDataTable $dataTable)
    {
        return $dataTable->render('app.news.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['success' => view('app.news.tags.create')->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_tags',
        ]);

        if ($validator->passes()) {
            $newsTag = new NewsTag();
            $newsTag->name = $request->name;
            $newsTag->slug = Str::slug($request->name);
            $newsTag->save();

            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsTag  $newsTag
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsTag $newsTag)
    {
        return response()->json(['success' => view('app.news.tags.edit', compact('newsTag'))->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsTag  $newsTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsTag $newsTag)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_tags,name,' .$newsTag->id,
        ]);

        if ($validator->passes()) {
            $newsTag->name = $request->name;
            $newsTag->slug = Str::slug($request->name);
            $newsTag->save();

            return response()->json(['success' => 'Record has been updated!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsTag  $newsTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsTag $newsTag)
    {
        $newsTag->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }

    public function destroyChecked(Request $request)
    {
        $newsTags = NewsTag::whereIn('id', $request->rowChecked);
        $newsTags->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }
}
