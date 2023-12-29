<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\RepositoryInterface;

/**
 * ProductRepositoryInterface for using with define method for ProductRepository Class
 * 27/12/2023
 * version:1
 */
interface ImageRepositoryInterface extends RepositoryInterface
{

    public function createNewImage(string $name, string $url, string $extension = "", string $product_id): Image;


}
