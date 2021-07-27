<?php

namespace App\Http\Controllers;

use App\DataTables\TagDataTable;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagDataTable $dataTable)
    {
        return $dataTable->render('app.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['success' => view('app.tags.create')->render()]);
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
            'name' => 'required|unique:tags',
        ]);

        if ($validator->passes()) {
            $tag = new Tag();
            $tag->name = $request->name;
            $tag->slug = Str::slug($request->name);
            $tag->save();

            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return response()->json(['success' => view('app.tags.edit', compact('tag'))->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name,' .$tag->id,
        ]);

        if ($validator->passes()) {
            $tag->name = $request->name;
            $tag->slug = Str::slug($request->name);
            $tag->save();

            return response()->json(['success' => 'Record has been updated!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }

    public function destroyChecked(Request $request)
    {
        $tags = Tag::whereIn('id', $request->rowChecked);
        $tags->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }
}
