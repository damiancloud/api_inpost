<?php
namespace App\Form\Inpost\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CityTransformer implements DataTransformerInterface
{
    /**
     * @return string
     */
    public function transform($value): string
    {
        return (string) $value;
    }

    /**
     * @return string
     */
    public function reverseTransform($value): string
    {
        if ($value !== null) {
            return ucfirst(strtolower($value));
        }

        throw new TransformationFailedException('City name should not be empty.');
    }
}