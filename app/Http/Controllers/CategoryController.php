<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('privado.categories.index', compact('categories'));
    }


    
    public function create()
    {
        return view('privado.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Activo,Inactivo',
        ]);

        Category::create($data);
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('privado.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Activo,Inactivo',
        ]);

        $category->update($data);
        return redirect()->route('categories.index');
    }
    public function show($id)
    {
        $category = Category::findOrFail($id); // Obtén la categoría que se va a mostrar
    
        return view('privado.categories.show', compact('category'));
    }
    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
