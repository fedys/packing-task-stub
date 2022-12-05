<?php

namespace App\Calculator;

use App\Packaging\PackagingBox;
use App\Packaging\ProductList;

class FallbackCalculator implements CalculatorInterface
{
    public function calculate(ProductList $productList): ?PackagingBox
    {
        return new PackagingBox(100, 200, 60);
    }
}
