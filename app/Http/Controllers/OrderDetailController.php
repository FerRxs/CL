<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::all();
        return view('privado.order_details.index', compact('orderDetails'));
    }

    public function create()
    {
        return view('privado.order_details.create'); 
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'status' => 'required|in:Activo,Inactivo',
        ]);

        OrderDetail::create($data);

        return redirect()->route('order_details.index')->with('success', 'Detalle de orden creado exitosamente.');
    }

    public function show(OrderDetail $order_detail)
    {
        return view('privado.order_details.show', compact('order_detail'));
    }

    public function edit(OrderDetail $order_detail)
    {
        return view('privado.order_details.edit', compact('order_detail'));
    }

    public function update(Request $request, OrderDetail $order_detail)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'status' => 'required|in:Activo,Inactivo',
        ]);

        $order_detail->update($data);

        return redirect()->route('order_details.index')->with('success', 'Detalle de orden actualizado exitosamente.');
    }

    public function destroy(OrderDetail $order_detail)
    {
        $order_detail->delete();
        return redirect()->route('order_details.index')->with('success', 'Detalle de orden eliminado exitosamente.');
    }
}
