<?php

namespace App\Calculator;

use App\Entity\Calculation;
use App\Entity\Packaging;
use App\Packaging\Api;
use App\Packaging\PackagingBox;
use App\Packaging\ProductList;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Exception\GuzzleException;

class ApiCalculator implements CalculatorInterface
{
    private EntityManager $entityManager;
    private Api $api;

    public function __construct(EntityManager $entityManager, Api $api)
    {
        $this->entityManager = $entityManager;
        $this->api = $api;
    }

    public function calculate(ProductList $productList): ?PackagingBox
    {
        try {
            $box = $this->api->packShipment($productList, $this->getPackages());
        } catch (GuzzleException $e) {
            return null;
        }

        $this->entityManager->persist(new Calculation($productList->getHash(), $box->toArray()));
        $this->entityManager->flush();

        return $box;
    }

    /**
     * @return Packaging[]
     */
    private function getPackages(): array
    {
        return $this->entityManager->getRepository(Packaging::class)->findAll();

        return array_map(function (Packaging $packaging) {
            return [
                'id' => $packaging->getId(),
                'h' => $packaging->getHeight(),
                'w' => $packaging->getWidth(),
                'd' => $packaging->getLength(),
                'max_wg' => $packaging->getMaxWeight(),
            ];
        }, $packages);
    }
}
