<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getCategories(bool $asTree = false): Collection
    {
        return Category::when($asTree, fn (Builder $query) => $query->tree())->get();
    }

    public function findCategory(string|int $id): Category
    {
        return Category::findOrFail($id);
    }
}
