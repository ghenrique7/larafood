<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    protected $product, $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
        $this->middleware(['can:products']);

    }


    public function categories(string $id)
    {
        if (!$product =  $this->product->find($id)) {
            return back()->with('error', 'O produto requisitado não foi encontrado.');
        }

        $categories = $product->categories()->paginate();

        return view('admin.pages.products.categories.categories', compact('product', 'categories'));
    }


    public function products(string $id)
    {
        if (!$category =  $this->category->find($id)) {
            return back()->with('error', 'A categoria requisitada não foi encontrada.');
        }

        $products = $category->products()->paginate();

        return view('admin.pages.categories.products.products', compact('products', 'category'));
    }

    public function categoriesAvailable(Request $request, string $id)
    {
        if (!$product =  $this->product->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        $filters = $request->only('filter');

        $categories = $product->categoriesAvailable($filters);

        return view('admin.pages.products.categories.available', compact('product', 'categories', 'filters'));
    }

    public function attachCategoriesProduct(Request $request, string $id)
    {
        if (!$product =  $this->product->find($id)) {
            return back()->with('error', 'O produto requisitado não foi encontrado.');
        }

        if (!$request->categories || count($request->categories) <= 0) {
            return back()->with('info', 'Selecione uma opção de vinculação.');
        }

        $product->categories()->attach($request->categories);

        return redirect()->route('products.categories', $product->id);
    }

    public function detachCategoriesProduct(string $idProduct, string $idCategory)
    {

        $product =  $this->product->find($idProduct);
        $category =  $this->category->find($idCategory);

        if (!$product || !$category) {
            return back()->with('error', 'O perfil ou permissão requisitados não foram encontrados.');
        }

        $product->categories()->detach($category);

        return redirect()->route('products.categories', $product->id);
    }
}
