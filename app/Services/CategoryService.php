<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends BaseService
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): bool
    {
        return $category->update($data);
    }
}
