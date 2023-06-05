<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn ($value, $attributes) => asset('storage/'.$attributes['image_path']));
    }

    public function scopeFilterBy(Builder $query, string $filter, string|int|null $value): Builder
    {
        return $query->when($filter === 'category' && $value, fn (Builder $query) => $query->whereRelation('categories', 'categories.id', $value));
    }

    public function scopeSortBy(Builder $query, string $sortBy, ?string $sortOrder = 'desc'): Builder
    {
        if ($sortOrder !== 'asc') {
            $sortOrder = 'desc';
        }

        return $query
            ->when($sortBy === 'price', function (Builder $query) use ($sortOrder) {
                return $query->orderBy('price', $sortOrder);
            });
    }

    public function attachImage(UploadedFile|string $image): bool
    {
        if ($image instanceof UploadedFile) {
            return $this->attachImageFromUploadedFile($image);
        }

        $tempFilePath = tempnam(sys_get_temp_dir(), 'file');

        file_put_contents($tempFilePath, file_get_contents($image));

        $image = new UploadedFile($tempFilePath, 'file');

        $attached = $this->attachImageFromUploadedFile($image);

        unlink($tempFilePath);

        return $attached;
    }

    private function attachImageFromUploadedFile(UploadedFile $image): bool
    {
        $imagesExtension = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'];

        throw_unless(in_array($image->guessExtension(), $imagesExtension), new InvalidArgumentException('File must be an image'));

        $basename = $this->id.'-'.time();

        $imagePath = $image->storeAs('products', "{$basename}.{$image->guessExtension()}");

        return $this->update(['image_path' => $imagePath]);
    }
}
