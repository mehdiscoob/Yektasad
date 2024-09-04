<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product;
}
