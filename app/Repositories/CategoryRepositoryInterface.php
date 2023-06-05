<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getCategories(bool $asTree = false): Collection;

    public function findCategory(string|int $id): Category;
}
