<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Repositories\RepositoryInterface;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ProductRepositoryInterface for using with define method for ProductRepository Class
 * 27/12/2023
 * version:1
 */
interface ProductRepositoryInterface extends RepositoryInterface
{

    public function getAllProductWithQuery($productName = "", $fromPrice = 0, $toPrice = 1000000000, $status = null, $perPage = 5): LengthAwarePaginator;

    public function getSingleProduct(string $id): Product;

    public function upsertProduct(ProductRequest|ProductUpdateRequest $request, string|null $product_id, string $user_id): array;
    public function getAllProductWithPagination(int $perPage = 5): LengthAwarePaginator;
    public function deleteProduct(string $id): void;
    public function _generateProductId(string $productName): string;
}
