<?php
// En PaymentController.php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class PaymentController extends Controller
{public function charge (Request $request)
    {
    
    /*     dd($request->all());  //Muestra todos los datos de la solicitud
     */
        // Obtener el usuario autenticado
        $user = auth()->user();
        if (!$user) {
            return back()->with('error', 'No estás autenticado.');
        }
    
        // Obtener los ítems del carrito
        $cartItems = Cart::getContent();
    
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío.');
        }
    
        // Obtener el token de Stripe del formulario de solicitud
        $stripeToken = $request->input('stripeToken');
    
        // Depuración: quitar después de la verificación
        // dd($stripeToken);
    
        if (!$stripeToken) {
            return back()->with('error', 'El token de Stripe no se recibió correctamente.');
        }
    
        // Configurar Stripe con la clave secreta
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        // Intentar crear el cargo con Stripe
        try {
            $charge = Charge::create([
                'amount' => round(Cart::getTotal() * 100), // en centavos y redondeado
                'currency' => 'usd',
                'description' => 'Pago de pedido',
                'source' => $stripeToken,
            ]);
    
            // Verificar si el cargo fue exitoso
            if ($charge->status == 'succeeded') {
                // Iniciar la transacción de la base de datos
                DB::beginTransaction();
    
                try {
                    // Crear una nueva orden
                    $order = $user->orders()->create([
                        'date' => now(),
                        'total' => Cart::getTotal(),
                        'status' => 'Pagado',
                    ]);
    
                    // Agregar los detalles de la orden
                    foreach ($cartItems as $item) {
                        $product = Product::find($item->id);
                        if ($product && $product->stock >= $item->quantity) {
                            $order->orderDetails()->create([
                                'product_id' => $item->id,
                                'quantity' => $item->quantity,
                                'unit_price' => $item->price,
                                'subtotal' => $item->getPriceSum(),
                            ]);
    
                            // Actualizar el stock del producto
                            $product->decrement('stock', $item->quantity);
                        } else {
                            throw new \Exception("Stock insuficiente para el producto {$product->name}.");
                        }
                    }
    
                    // Vaciar el carrito después de crear la orden
                    Cart::clear();
    
                    // Confirmar la transacción
                    DB::commit();
    
                    // Redirigir al usuario a la página de confirmación de la orden
                    return redirect()->route('public.orders.show', $order->id)->with('success', 'Tu pedido ha sido procesado y el pago fue exitoso.');
                } catch (\Exception $e) {
                    // Revertir la transacción si hay un problema
                    DB::rollBack();
                    return back()->with('error', 'Error al crear la orden: ' . $e->getMessage());
                }
            } else {
                return back()->with('error', 'El pago no fue exitoso.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
            }
}
