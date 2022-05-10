<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidRegPlate extends Constraint
{
    public $message = 'The Registration Plate "{{ string }}" is not in the correct format .';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties
}
