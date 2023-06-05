<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('products');

        Category::factory()
            ->has(Category::factory()->count(2), 'parent')
            ->has(Product::factory()->count(2))
            ->create();

        Category::factory()
            ->has(Category::factory()->count(3), 'parent')
            ->has(Product::factory()->count(4))
            ->create();

        $category = Category::factory()->create(['parent_id' => Category::first()->id]);

        Category::factory()->count(2)->create(['parent_id' => $category->id]);
    }
}
