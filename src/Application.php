<?php

namespace App;

use App\Calculator\CalculatorInterface;
use App\Packaging\Exception\ProductListParserException;
use App\Packaging\ProductListParser;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Application
{
    private EntityManager $entityManager;
    private ProductListParser $productListParser;
    private CalculatorInterface $calculator;

    public function __construct(EntityManager $entityManager, ProductListParser $productListParser, CalculatorInterface $calculator)
    {
        $this->entityManager = $entityManager;
        $this->productListParser = $productListParser;
        $this->calculator = $calculator;
    }

    public function run(RequestInterface $request): ResponseInterface
    {
        try {
            $productList = $this->productListParser->parseList($request->getBody());
        } catch (ProductListParserException $e) {
            return new Response(422, [], $e->getMessage());
        }

        $box = $this->calculator->calculate($productList);

        if (!$box) {
            throw new RuntimeException('There is no way to calculate the box.');
        }

        return new Response(200, [], json_encode($box->toArray()));
    }
}
