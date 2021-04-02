<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{
    
    public function index()
    {
        return Item::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
        ]);

        $category = Category::find($request->category);
        if (!$category) {
            $category = Category::create([
                'name' => $request->category,
                'slug' => Str::slug($request->category)
            ]);
        }

        return Item::create([
            'category_id' => $category->id,
            'title' => $request->title
        ]);
    }

    public function show(Item $item)
    {
        $item->load('category');

        return $item;
    }

    public function update(Item $item, Request $request)
    {
        $request->validate([
            'is_complete' => 'required|boolean'
        ]);

        if ($request->category) {
            $category = Category::find($request->category);
            if (!$category) {
                $category = Category::create([
                    'name' => $request->category,
                    'slug' => Str::slug($request->category)
                ]);
            }

            return $item->update([
                'category_id' => $category->id,
                'is_complete' => $request->is_complete
            ]);
        }

        return $item->update($request->only(['is_complete']));
    }

    public function destroy(Item $item, Request $request)
    {
        return $item->delete();
    }

}
