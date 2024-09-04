<?php

namespace App\Services\Product;

use App\Models\Product;

interface ProductServiceInterface
{
    /**
     * Create a new product with validation.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function findProduct(int $id): ?Product;
}
