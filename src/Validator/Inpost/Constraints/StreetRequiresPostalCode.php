<?php
namespace App\Validator\Inpost\Constraints;

use Symfony\Component\Validator\Constraint;

class StreetRequiresPostalCode extends Constraint
{
    public $message = 'If you enter a street, you must also provide a postal code.';
}