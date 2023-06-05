<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created_from_cli(): void
    {
        $this->arrangeForProductCreation();

        $this->artisan('products:create')
            ->expectsQuestion('Name', 'test name')
            ->expectsQuestion('Description', 'test description')
            ->expectsQuestion('Price', 10)
            ->expectsQuestion('Image URL', 'https://placehold.co/600x400/jpg')
            ->expectsQuestion('Enter categories ids (seperated by comma)', '1,2,3')
            ->assertSuccessful();

        $this->assertProductWasCreated();
    }

    public function test_product_can_be_created_from_api(): void
    {
        $this->arrangeForProductCreation();

        $response = $this->post(route('products.store'), [
            'name' => 'test name',
            'description' => 'test description',
            'price' => 10,
            'image' => UploadedFile::fake()->image('image.jpg'),
            'selected_categories_ids' => [1, 2, 3],
        ]);

        $response->assertSuccessful()->assertJson(['created' => true]);

        $this->assertProductWasCreated();
    }

    private function arrangeForProductCreation(): void
    {
        Storage::fake('public');

        Category::factory()->count(3)->create();
    }

    private function assertProductWasCreated(): void
    {
        $product = Product::first();

        $this->assertModelExists($product);

        $this->assertDatabaseHas(Product::class, [
            'name' => 'test name',
            'description' => 'test description',
            'price' => 10,
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => 1,
        ]);

        $this->assertDatabaseCount('category_product', 3);

        /**
         * @var \Illuminate\Filesystem\FilesystemAdapter
         */
        $publicDisk = Storage::disk('public');

        $publicDisk->assertExists($product->image_path);
    }
}
