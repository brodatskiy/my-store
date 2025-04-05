<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller as Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\FilterRequest;
use App\Http\Resources\Product\ProductCardResource;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Contracts\Container\BindingResolutionException;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function __invoke(FilterRequest $request): \Inertia\Response
    {
        $data = $request->validated();

        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);

        $products = Product::query()
            ->filter($filter)
            ->sorted()
            ->paginate(8)
            ->withQueryString();

        $tags = Tag::all();
        $minPrice = Product::orderBy('price', 'ASC')->first()->price ?? 0;
        $maxPrice = Product::orderBy('price', 'DESC')->first()->price ?? 1000;

        return Inertia::render('Client/Home/Index', [
            'sort' => $request->sort ?? 'popularity',
            'search' => $request->search ?? '',
            'products' => ProductCardResource::collection($products),
            'tags' => $tags,
            'price' => $request->price ?? [$minPrice, $maxPrice],
        ]);
    }
}
