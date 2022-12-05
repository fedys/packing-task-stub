<?php

namespace App\Calculator;

use App\Entity\Calculation;
use App\Packaging\PackagingBox;
use App\Packaging\ProductList;
use Doctrine\ORM\EntityManager;

class ExistingCalculator implements CalculatorInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculate(ProductList $productList): ?PackagingBox
    {
        /** @var Calculation|null $calculation */
        $calculation = $this->entityManager->find(Calculation::class, $productList->getHash());

        if (!$calculation) {
            return null;
        }

        $data = $calculation->getBox();

        return new PackagingBox($data['width'], $data['height'], $data['length']);
    }
}
