<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductSpec
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="product_spec")
 */
class ProductSpec
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spec", inversedBy="spec")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $spec;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $value;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->spec = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getSpec(): Collection
    {
        return $this->spec;
    }

    /**
     * @param mixed $spec
     */
    public function setSpec($spec): void
    {
        $this->spec = $spec;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
