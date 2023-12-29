<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

/**
 * ProductController for crud product in the app
 * 27/12/2023
 * version:1
 */
class ProductController extends Controller
{
    protected $productRepo;
    protected $imageRepo;

    /**
     * Constructs a new instance of the class with injct product repo.
     *
     * @param ProductRepositoryInterface $productRepo The product repository.
     * 28/12/2023
     * version:2
     */
    public function __construct(ProductRepositoryInterface $productRepo, ImageRepositoryInterface $imageRepo)
    {
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * Retrieves all products based on search criteria and returns a view.
     *
     * @param ProductSearchRequest $request the search criteria
     * @return View the view containing the list of products
     * 27/12/2023
     * version:1
     */
    public function index(ProductSearchRequest $request): View
    {

        $strProductName = $request->input("productName");
        $fFromPrice = $request->input("fromPrice");
        $fToPrice = $request->input("toPrice");
        $iStatus = $request->input("status");
        $iPerPage = $request->input("perPage", 10);

        $products = $this->productRepo->getAllProductWithQuery($strProductName,
            $fFromPrice,
            $fToPrice,
            $iStatus, $iPerPage);

        $this->_transformProduct($products);
        return view('pages.products.index', [
            'products' => $products,
            'strProductName' => $strProductName,
            'fFromPrice' => $fFromPrice,
            'fToPrice' => $fToPrice,
            'iStatus' => $iStatus,
            'iPerPage' => $iPerPage
        ]);
    }

    /**
     * Paginate the products using AJAX.
     *
     * @param Request $request The HTTP request object.
     * @return JsonResponse The JSON response containing the product table view and pagination links.
     * 27/12/2023
     * version:1
     */
    public function paginateAjax(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $queryParam = $this->_getQueryParamAjax($request);
            extract($queryParam);
            $products = $this->productRepo->getAllProductWithQuery($strProductName,
                $fFromPrice,
                $fToPrice,
                $iStatus, $iPerPage);

            $this->_transformProduct($products);

            return response()->json([
                'view' => view('pages.products.partial.product-table', compact('products'))->render(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }
    }

    public function deleteAjax(Request $request, string $id)
    {

        if ($request->ajax()) {
            $this->productRepo->deleteProduct($id);
            $queryParam = $this->_getQueryParamAjax($request);
            extract($queryParam);
            $products = $this->productRepo->getAllProductWithQuery($strProductName,
                $fFromPrice,
                $fToPrice,
                $iStatus, $iPerPage);

            $this->_transformProduct($products);
            return response()->json([
                'view' => view('pages.products.partial.product-table', [
                    "products" => $products,
                    "deleteMessage" => "Product deleted successfully",
                ])->render(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }
    }



    /**
     * Create a new product.
     *
     * @param ProductSearchRequest $request The request object containing the product search data.
     * @return View The view object for the 'pages.products.upsert.product-upsert' page.
     * 27/12/2023
     * version:1
     */
    public function create(ProductSearchRequest $request): View
    {

        return view('pages.products.upsert.product-upsert');
    }

    /**
     * Store a new product.
     *
     * @param ProductRequest $request The request object.
     * @return RedirectResponse The redirect response.
     *  27/12/2023
     * version:1
     */
    public function store(ProductRequest $request): RedirectResponse
    {


        $fileUpload = $request->file('fileUpload');
        $user_id = Auth::id();

        $newProduct = $this->productRepo->upsertProduct($request, null, $user_id);

        if ($fileUpload) {
            // Get the original file name
            $fileName = $fileUpload->getClientOriginalName() . "-" . $newProduct["id"];

            // Get the file extension
            $fileExtension = $fileUpload->getClientOriginalExtension();

            // Define the path to store the file
            $destinationPath = 'public/uploads';

            // Store the file and get the path
            $storedPath = $fileUpload->storeAs($destinationPath, $fileName);

            // Get the URL of the stored file
            $fileUrl = Storage::url($storedPath);

            $this->imageRepo->createNewImage($fileName, $fileUrl, $fileExtension, $newProduct["id"]);
        }

        return redirect()->route("admin.product.get");

    }

    public function edit(Request $request, string $id): View
    {
        $product = $this->productRepo->getSingleProduct($id);

        return view('pages.products.upsert.product-upsert', ["id" => $id, "product" => $product]);
    }

    public function update(ProductUpdateRequest $request, string $id): RedirectResponse
    {
        $fileUpload = $request->file('fileUpload');
        $user_id = Auth::id();

        $newProduct = $this->productRepo->upsertProduct($request, $id, $user_id);
        if ($fileUpload) {
            // Get the original file name
            $fileName = $fileUpload->getClientOriginalName() . "-" . $newProduct["id"];

            // Get the file extension
            $fileExtension = $fileUpload->getClientOriginalExtension();

            // Define the path to store the file
            $destinationPath = 'public/uploads';

            // Store the file and get the path
            $storedPath = $fileUpload->storeAs($destinationPath, $fileName);

            // Get the URL of the stored file
            $fileUrl = Storage::url($storedPath);

            $this->imageRepo->createNewImage($fileName, $fileUrl, $fileExtension, $id);
        }

        return redirect()->route("admin.product.get");
    }

    /**
     * Deletes a product.
     *
     * @param Request $request The request object.
     * @param string $id The ID of the product to delete.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {

        $this->productRepo->deleteProduct($id);
        return redirect()->route("admin.product.get");
    }

    /**
     * Transforms the given LengthAwarePaginator of products.
     *
     * @param LengthAwarePaginator $products The LengthAwarePaginator object to transform.
     * @throws None
     * @return void
     *  27/12/2023
     * version:1
     */
    private function _transformProduct(LengthAwarePaginator $products): void
    {
        $products->map(function ($product) {
            $product->status_name = ($product->status === 0) ?
                "Đang bán" : (($product->status === 1) ? "Dừng bán" : "Hết hàng");
            return $product;
        });
    }

    private function _getQueryParamAjax(Request $request): array
    {
        $iPerPage = $request->get('perPage', 5);
        $strProductName = $request->get('productName', '');
        $fFromPrice = $request->get('fromPrice', 0);
        $fToPrice = $request->get('toPrice', 1000000000);
        $iStatus = $request->get('status', null);

        return [
            "iPerPage" => $iPerPage,
            "strProductName" => $strProductName,
            "fFromPrice" => $fFromPrice,
            "fToPrice" => $fToPrice,
            "iStatus" => $iStatus

        ];
    }
}
