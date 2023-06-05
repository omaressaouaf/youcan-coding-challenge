<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProducts(string|int|null $categoryId = null, ?string $sortBy = null, ?string $sortOrder = null): Collection
    {
        return Product::query()
            ->with('categories')
            ->when($categoryId, fn (Builder $query) => $query->filterBy('category', $categoryId))
            ->when($sortBy, fn (Builder $query) => $query->sortBy($sortBy, $sortOrder))
            ->get();
    }

    public function findProduct(string|int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
            ]);

            $product->categories()->sync($data['selected_categories_ids']);

            $product->attachImage($data['image']);

            return $product->refresh();
        });
    }
}
