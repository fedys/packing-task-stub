<?php


namespace App\Packaging;



class PackagingBox
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

    public function __construct(float $width, float $height, float $length)
    {
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
    }


    public function toArray(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'length' => $this->length,
        ];
    }
}
