<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Image\ImageRepositoryInterface;

/**
 * ProductRepository for using with rproduct crud
 * 27/12/2023
 * version:1
 */
class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    public function getModel()
    {
        return Image::class;
    }
    public function createNewImage(string $name, string $url, string $extension = "", string $product_id): Image
    {
        return Image::create([
            "img_name" => $name,
            "img_url" => $url,
            "img_extension" => $extension,
            "product_id" => $product_id,
        ]);
    }


}
