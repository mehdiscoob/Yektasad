<?php

namespace App\Services\Product;

use App\Jobs\SendProductCreatedEmail;
use App\Mail\Product\ProductCreated;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductService implements ProductServiceInterface
{
    protected ProductRepositoryInterface $productRepository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Create a new product with validation.
     *
     * @param array $data
     * @return Product
     * @throws ValidationException
     */
    public function createProduct(array $data): Product
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $product=$this->productRepository->create($data);
        SendProductCreatedEmail::dispatch($product);
        return $product;
    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function findProduct(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
