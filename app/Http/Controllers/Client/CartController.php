<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItem\CartItemResource;
use App\Models\Order;
use App\Models\Product;
use App\Service\CartService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        return Inertia::render('Client/Cart/Index', [
            'products' => CartItemResource::collection($cartItems),
            'total' => $this->cartService->getTotal()
        ]);
    }

    /**
     * @throws Throwable
     */
    public function order()
    {
        if (auth()->check()) {
            try {
                DB::beginTransaction();

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $this->cartService->getTotal(),
                    'status' => OrderStatus::Unpaid
                ]);

                $cartItems = $this->cartService->getItems();

                if ($cartItems->count() === 0) {
                    throw new Exception('empty cart');
                }

                foreach ($cartItems as $cartItem) {
                    $order->orderItems()->create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'price' => $cartItem->price,
                        'quantity' => $cartItem->count,
                    ]);
                }

                $this->cartService->destroy();

                Db::commit();

                return redirect()->route('orders.index');
            } catch (Exception $exception) {
                Db::rollBack();
                abort(500);
            }
        } else {
            return back();
        }
    }

    public function add(Product $product): RedirectResponse
    {
        $this->cartService->add($product);

        return back();
    }

    public function increase(Product $product)
    {
        $this->cartService->increase($product);

        return back();
    }

    public function decrease(Product $product)
    {
        $this->cartService->decrease($product);

        return back();
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->cartService->destroyItem($product);

        return back();
    }
}
