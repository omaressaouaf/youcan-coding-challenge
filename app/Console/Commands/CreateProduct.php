<?php

namespace App\Console\Commands;

use App\Console\Traits\AsksWithValidation;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    use AsksWithValidation;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new product';

    /**
     * Execute the console command.
     */
    public function handle(ProductRepositoryInterface $productRepository)
    {
        $name = $this->askWithValidation('Name', 'required|string', 'name');

        $description = $this->askWithValidation('Description', 'required|string', 'description');

        $price = $this->askWithValidation('Price', 'required|numeric|min:0', 'price');

        $imageUrl = $this->askWithValidation('Image URL', 'required|url', 'image_url');

        $selectedCategoriesIds = $this->askForCategories();

        $product = $productRepository->createProduct([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $imageUrl,
            'selected_categories_ids' => $selectedCategoriesIds,
        ]);

        $this->info("Product id {$product->id} has been created successfully");

        return Command::SUCCESS;
    }

    private function askForCategories(): array
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);

        $categories = $categoryRepository->getCategories();

        foreach ($categories as $category) {
            $this->line("{$category->id}. {$category->name}");
        }

        $selectedCategoriesIds = $this->askWithValidation(
            'Enter categories ids (seperated by comma)',
            'required|string',
            'selected_categories_ids'
        );

        $selectedCategoriesIds = explode(',', $selectedCategoriesIds);

        $allCategoriesIds = $categories->pluck('id')->toArray();

        if (count(array_diff($selectedCategoriesIds, $allCategoriesIds)) > 0) {
            $this->error('Please enter correct categories ids');

            return $this->askForCategories();
        }

        return $selectedCategoriesIds;
    }
}
