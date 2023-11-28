<?php
namespace App\Validator\Inpost;

class ResourceValidator
{
    /**
     * @param mixed $resource
     * 
     * @return void
     */
    public function validate($resource): void
    {
        if ($resource !== 'points') {
            throw new \InvalidArgumentException('Invalid resource. Supported resource: "points".');
        }
    }
}