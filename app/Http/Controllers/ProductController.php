<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $productImages = [];
        foreach ($products as $product) {
            $productImages[$product->id] = [
                'image1' => asset('storage/' . $product->image1),
                'image2' => asset('storage/' . $product->image2),
                'image3' => asset('storage/' . $product->image3),
            ];
        }
        return view('privado.products.index', compact('products', 'productImages'));
    }
    
    public function show($id)
    {
        $product = Product::findOrFail($id); // Obtén el producto que se va a mostrar
    
        $productImages = [
            'image1' => asset('storage/' . $product->image1),
            'image2' => asset('storage/' . $product->image2),
            'image3' => asset('storage/' . $product->image3),
        ];
    
        return view('privado.products.show', compact('product', 'productImages'));
    }
    
    
    public function create()
    {
        $categories = Category::all(); // Obtén todas las categorías desde el modelo Category
        return view('privado.products.create', compact('categories'));
    }
    public function edit($id)
{
    $product = Product::findOrFail($id); // Obtén el producto que se va a editar
    $categories = Category::all(); // Obtén todas las categorías para el campo de selección

    return view('privado.products.edit', compact('product', 'categories'));
}


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Activo,Inactivo,Descontinuado',
        ]);

        // Procesar imágenes
        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('images/products', 'public');
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('images/products', 'public');
        }
        if ($request->hasFile('image3')) {
            $data['image3'] = $request->file('image3')->store('images/products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Activo,Inactivo,Descontinuado',
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->status = $request->input('status');

        // Manejar la subida de las imágenes
        $imagePaths = [];
        $deleteOldImages = false;
        for ($i = 1; $i <= 3; $i++) {
            $fieldName = 'image' . $i;
            if ($request->hasFile($fieldName)) {
                // Guardar la nueva imagen y anotar que se debe eliminar la antigua
                $path = $request->file($fieldName)->store('images/products', 'public');
                if ($path) {
                    $imagePaths[$fieldName] = $path;
                    $deleteOldImages = true;
                }
            }
        }
    
        // Comprobar si hay nuevas imágenes antes de eliminar las antiguas
        if ($deleteOldImages) {
            for ($i = 1; $i <= 3; $i++) {
                $fieldName = 'image' . $i;
                if (array_key_exists($fieldName, $imagePaths)) {
                    // Eliminar la imagen anterior si existe
                    if ($product->$fieldName) {
                        Storage::delete('public/' . $product->$fieldName);
                    }
                    // Asignar el nuevo path al modelo
                    $product->$fieldName = $imagePaths[$fieldName];
                }
            }
        }
    
        // Guardar cambios en el producto
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
