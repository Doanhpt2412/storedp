<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\ProductCatalog;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function show(ProductCatalog $catalog, string $slug): View
    {
        $product = $catalog->find($slug);

        if (! $product) {
            throw new NotFoundHttpException();
        }

        return view('frontend.products.show', [
            'navCategories' => $catalog->navCategories(),
            'product' => $product,
            'productBreadcrumbs' => $catalog->productBreadcrumbs($slug),
            'relatedProducts' => $catalog->related($slug),
        ]);
    }
}
