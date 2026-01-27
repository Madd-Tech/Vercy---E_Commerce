<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        return Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $cat = Category::findOrFail($id);
        $cat->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return $cat;
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
