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
        return response()->json(['success' => view('app.news.categories.partials.form')->render()]);
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

    public function edit($id)
    {
        $newsCategory = NewsCategory::find($id);

        return response()->json([
            'success' => view('app.news.categories.partials.form', ['update' => true])->render(),
            'data' => $newsCategory
        ]);
    }

    public function update(Request $request, $id)
    {
        $newsCategory = NewsCategory::find($id);
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

    public function destroy($id)
    {
        $newsCategory = NewsCategory::find($id);
        $newsCategory->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }
}
