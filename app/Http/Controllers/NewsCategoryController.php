<?php

namespace App\Http\Controllers;

use App\DataTables\NewsCategoryDataTable;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index(NewsCategoryDataTable $dataTable)
    {
        $title = 'Categories';

        return $dataTable->render('app.news.categories.index', compact('title'));
    } 

    public function create()
    {
        return response()->json(['success' => view('app.news.categories.create')->render()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_categories',
        ]);

        if ($validator->passes()) {
            $newsCategory = new NewsCategory();
            $newsCategory->name = $request->name;
            $newsCategory->slug = Str::slug($request->name);
            $newsCategory->save();
            
    
            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(NewsCategory $newsCategory)
    {
        return response()->json(['success' => view('app.news.categories.edit', compact('newsCategory'))->render()]);
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_categories,name,' .$newsCategory->id,
        ]);

        if ($validator->passes()) {
            $newsCategory->name = $request->name;
            $newsCategory->slug = Str::slug($request->name);
            $newsCategory->save();
    
            return response()->json(['success' => 'Record has been updated!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(NewsCategory $newsCategory)
    {
        $newsCategory->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }
}
