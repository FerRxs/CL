<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('privado.orders.index', compact('orders'));
    }
    public function create()
    {
        $products = Product::all(); // Obtén la lista de productos desde la base de datos
        return view('privado.orders.create', compact('products')); // Pasa la lista de productos a la vista
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Pendiente,Enviado,Entregado,Cancelado',
        ]);
          // Obtén el producto seleccionado
          $product = Product::findOrFail($data['product_id']);
          // Calcula el total basado en la cantidad y el precio del producto
          $data['total'] = $product->price * $data['quantity'];
          // Crea la orden
          Order::create($data);

        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
    }
    public function show(Order $order)
    {
        return view('privado.orders.show', compact('order'));
    }
    public function edit(Order $order)
    {
        return view('privado.orders.edit', compact('order'));
    }
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Pendiente,Enviado,Entregado,Cancelado',
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Orden eliminada exitosamente.');
    }



    public function showPublic(Order $order)
{
    // Verificar que el usuario autenticado es el propietario del pedido
    if (auth()->id() !== $order->user_id) {
        abort(403); // O redirigir con un mensaje de error si prefieres
    }
   
       // Cargar los detalles del pedido

    $order->load('orderDetails.product');

    return view('publico.orders.show', compact('order'));
}

}




