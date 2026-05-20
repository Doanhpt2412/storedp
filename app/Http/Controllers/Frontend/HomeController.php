<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\ProductCatalog;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(ProductCatalog $catalog): View
    {
        return view('frontend.home', [
            'featuredCategories' => $catalog->featuredCategories(),
            'homeBanners' => $catalog->homeBanners(),
            'heroSlides' => $catalog->heroSlides(),
            'navCategories' => $catalog->navCategories(),
            'productSections' => $catalog->productSections(),
            'promotions' => $catalog->promotions(),
            'serviceHighlights' => $catalog->serviceHighlights(),
        ]);
    }
}
