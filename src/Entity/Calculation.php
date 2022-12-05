<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Calculation
{
    /**
     * @ORM\Id
     * @ORM\Column()
     */
    private string $hash;

    /**
     * @ORM\Column(type="array")
     */
    private array $box;

    /**
     * @param string $hash
     * @param array $box
     */
    public function __construct(string $hash, array $box)
    {
        $this->hash = $hash;
        $this->box = $box;
    }

    public function getBox(): array
    {
        return $this->box;
    }
}
