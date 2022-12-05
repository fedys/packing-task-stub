<?php


namespace App\Packaging;



use App\Packaging\Exception\ProductListParserException;

class ProductListParser
{
    /**
     * @throws ProductListParserException
     */
    public function parseList(string $rawData): ProductList
    {
        $data = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new ProductListParserException('Data must be of type array.');
        }

        if (!$data) {
            throw new ProductListParserException('Data must not be empty.');
        }

        $productList = new ProductList();

        foreach ($data as $item) {
            $productList->add($this->createProduct($item));
        }

        return $productList;
    }

    /**
     * @param mixed $item
     * @return Product
     * @throws ProductListParserException
     */
    private function createProduct($item): Product
    {
        if (!is_array($item)) {
            throw new ProductListParserException('Item must be of type array.');
        }

        $keys = ['width', 'height', 'length', 'weight'];

        foreach ($keys as $key) {
            if (!isset($item[$key])) {
                throw new ProductListParserException(sprintf('Item key "%s" must exist.', $key));
            }

            if (!is_float($item[$key]) && !is_int($item[$key])) {
                throw new ProductListParserException(sprintf('Item key "%s" must be either of type float or int.', $key));
            }

            if ($item[$key] <= 0) {
                throw new ProductListParserException(sprintf('Item key "%s" must be greater than 0.', $key));
            }
        }

        return new Product($item['width'], $item['height'], $item['length'], $item['weight']);
    }
}
