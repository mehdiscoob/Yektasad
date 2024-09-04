<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product
     */
    protected Product $product;

    /**
     * ProductRepository constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return $this->product->create($data);

    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product
    {
        return $this->product->find($id);
    }
}
