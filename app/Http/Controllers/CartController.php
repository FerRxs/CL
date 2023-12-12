<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{

    public function checkoutForm()
    {
        $cartItems = Cart::getContent();
        return view('publico.cart.checkout', compact('cartItems'));
    }

    public function index()
    {
        $cartItems = Cart::getContent();
        return view('publico.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product || $product->stock < $request->quantity) {
            return back()->with('error', 'Producto no disponible en la cantidad deseada.');
        }
        
        Cart::add($request->id, $product->name, $product->price, $request->quantity, array());
        return back()->with('success', 'Producto añadido al carrito correctamente.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product || $product->stock < $request->quantity) {
            return back()->with('error', 'Cantidad no disponible.');
        }
        
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);
        return back()->with('success', 'Carrito actualizado correctamente.');
    }
    

    public function remove($id)
    {
        Cart::remove($id);
        return back()->with('success', 'Producto eliminado del carrito correctamente.');
    }

    public function clear()
    {
        Cart::clear();
        return back()->with('success', 'Carrito vaciado correctamente.');
    }

    public function count()
{
    return response()->json(['count' => Cart::getContent()->count()]);
}

    }