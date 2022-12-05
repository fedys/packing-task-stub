<?php

namespace App\Calculator;

use App\Packaging\PackagingBox;
use App\Packaging\ProductList;

interface CalculatorInterface
{
    public function calculate(ProductList $productList): ?PackagingBox;
}
