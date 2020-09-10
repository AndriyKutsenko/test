<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CostTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $priceInt
     * @return mixed|string|void
     */
    public function transform($priceInt)
    {
        if (null === $priceInt) {
            return;
        }

        return number_format(($priceInt /100), 2, '.', ' ');
    }

    /**
     * @param mixed $priceDouble
     * @return int|mixed|void
     */
    public function reverseTransform($priceDouble)
    {
        if (null === $priceDouble) {
            return;
        }

        return (int)($priceDouble * 100);
    }
}