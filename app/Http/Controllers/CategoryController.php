<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $categories = Category::where('title', 'LIKE', '%'. $search . '%')->latest('id')->paginate(10);
        return view('categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('categories.create');
    }

    /**
     * Generate a slug from the given title.
     *
     * @param string $title
     * @return string
     */
    private function generateSlug($title)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $count = Category::where('slug', 'LIKE', $slug . '%')->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
    public function store(CategoryRequest $request)
    {
        $slug = $this->generateSlug($request->title);
        $request->merge(['slug' => $slug]);
        $category = Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
