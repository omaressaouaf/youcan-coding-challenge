<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    public $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return response()->json([
            'categories' => $this->categoryRepository->getCategories(request('asTree') ? true : false),
        ]);
    }
}
