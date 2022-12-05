<?php

namespace App\Calculator;

use App\Entity\Calculation;
use App\Packaging\PackagingBox;
use App\Packaging\ProductList;
use Doctrine\ORM\EntityManager;

class CompositeCalculator implements CalculatorInterface
{
    /**
     * @var CalculatorInterface[]
     */
    private array $calculators = [];

    public function add(CalculatorInterface $calculator)
    {
        $this->calculators[] = $calculator;
    }

    public function calculate(ProductList $productList): ?PackagingBox
    {
        foreach ($this->calculators as $calculator) {
            $box = $calculator->calculate($productList);

            if ($box) {
                return $box;
            }
        }

        return null;
    }
}
