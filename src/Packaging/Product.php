<?php


namespace App\Packaging;


class Product
{
    /**
     * @var float
     */
    private float $width;
    /**
     * @var float
     */
    private float $height;
    /**
     * @var float
     */
    private float $length;
    /**
     * @var float
     */
    private float $weight;

    public function __construct(float $width, float $height, float $length, float $weight)
    {
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getLength(): float
    {
        return $this->length;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getHash(): string
    {
        return md5($this->width.':'.$this->height.':'.$this->length.':'.$this->weight);
    }
}
