<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getProducts(string|int|null $categoryId = null, ?string $sortBy = null, ?string $sortOrder = null): Collection;

    public function findProduct(string|int $id): Product;

    public function createProduct(array $data): Product;
}
