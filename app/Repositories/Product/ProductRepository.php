<?php
namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Repositories\BaseRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Product\ProductRepositoryInterface;

/**
 * ProductRepository for using with rproduct crud
 * 27/12/2023
 * version:1
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\Product::class;
    }


    /**
     * Retrieves all products based on the given query parameters.
     *
     * @param string $productName The name of the product to search for.
     * @param int|null $fromPrice The minimum price of the products to retrieve. Default is 0.
     * @param int|null $toPrice The maximum price of the products to retrieve. Default is 1000000000.
     * @param string|null $status The status of the products to retrieve. Default is null.
     * @param int|null $perPage The number of products to retrieve per page. Default is 10.
     * @throws Some_Exception_Class A description of the exception that may be thrown.
     * @return Illuminate\Pagination\LengthAwarePaginator The paginated list of products.
     * 28/12/2023
     * version:2
     */
    public function getAllProductWithQuery($productName="", $fromPrice=0, $toPrice= 1000000000, $status=null, $perPage=5): LengthAwarePaginator
    {
        return $this->model::with("images")
            ->where("product_name", "like", "%{$productName}%")
            ->whereBetween("price", [$fromPrice ?? 0, $toPrice ?? 1000000000])
            ->when($status !== null && $status !== "-1", function ($query) use ($status) {
                return $query->where('status', $status);
            })->orderBy("updated_at", 'desc')->paginate($perPage ?? 10);
    }


    /**
     * Retrieves all products with pagination.
     *
     * @param int $perPage The number of items per page (default: 10)
     * @return LengthAwarePaginator The paginated list of products
     * 28/12/2023
     * version:2
     */
    public function getAllProductWithPagination(int $perPage = 5): LengthAwarePaginator
    {

        return $this->model::with("images")->orderBy("updated_at", 'desc')->paginate($perPage ?? 5);
    }

    /**
     * Upserts a product into the database.
     *
     * @param ProductRequest $request The product request object.
     * @param string $user_id The ID of the user.
     * @throws Some_Exception_Class Description of exception.
     * @return void
     * 28/12/2023
     * version:2
     */
    public function upsertProduct(ProductRequest|ProductUpdateRequest $request, string|null $product_id, string $user_id): array
    {

        $onlyProduct = collect($request->all())->only(['productName', 'description', 'price', 'status']);
        $currentID = $this->_generateProductId($onlyProduct['productName']);

        $onlyProduct['id'] = $product_id === null ? $currentID : $product_id;
        $onlyProduct['user_id'] = $user_id;



        $renamedProduct = $onlyProduct->mapWithKeys(function ($value, $key) {
            if ($key === 'productName') {
                return ['product_name' => $value];
            }

            return [$key => $value];
        });
        $newProduct = $this->model::updateOrCreate($renamedProduct->toArray());
        return ['product' => $newProduct, 'id' => $currentID];
    }

    /**
     * Retrieves a single product based on the provided ID.
     *
     * @param string $id The ID of the product.
     * @throws Some_Exception_Class Description of exception.
     * @return Product The retrieved product.
     * 28/12/2023
     * version:2
     */
    public function getSingleProduct(string $id): Product
    {

        return $this->model::with("images")->where("id", $id)->first();
    }

    /**
     * Deletes a product based on the provided ID.
     *
     * @param string $id The ID of the product to be deleted.
     * @throws Some_Exception_Class Description of the exception that may be thrown.
     * @return void
     * 28/12/2023
     * version:2
     */
    public function deleteProduct(string $id): void
    {

        $this->model::where('id', $id)->delete();

        
    }

    /**
     * Generates a unique product ID based on the given product name.
     *
     * @param string $productName The name of the product.
     * @return string The generated product ID.
     * 28/12/2023
     * version:1
     */
    public function _generateProductId(string $productName): string
    {
        $prefix = strtoupper(substr($productName, 0, 1));
        $suffix = now()->format('YmdHis');
        ;
        return $prefix . $suffix;
    }
}
