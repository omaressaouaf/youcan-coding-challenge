<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProductRequest;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    public $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return response()->json([
            'products' => $this->productRepository->getProducts(request('categoryId'), request('sortBy'), request('sortOrder')),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->createProduct($request->validated());

        return response()->json([
            'created' => true,
            'product' => $product,
        ]);
    }
}
