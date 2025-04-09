<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItem\CartItemResource;
use App\Models\Cart;
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
//        $this->cartService->mergeCarts();
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
                    'status' => 'Unpaid'
                ]);

                $cartItems = $this->cartService->getItems();

                foreach ($cartItems as $cartItem) {
                    $order->orderItems()->create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'price' => $cartItem->price,
                        'count' => $cartItem->count,
                    ]);
                }

                $this->cartService->destroy();
                Db::commit();

                return back();
            } catch (Exception $e) {
                dd($e->getMessage());
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
