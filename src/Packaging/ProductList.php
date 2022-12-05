<?php


namespace App\Packaging;



class ProductList
{
    /**
     * @var Product[]
     */
    private array $products = [];

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * @return Product[]
     */
    public function toArray(): array
    {
        return $this->products;
    }

    public function getHash(): string
    {
        if (!$this->products) {
            throw new \LogicException('Product list must not be empty.');
        }

        $hashes = array_map(fn(Product $product) => $product->getHash(), $this->products);
        sort($hashes);

        return md5(implode(':', $hashes));
    }
}
