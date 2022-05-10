<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidNumChasis extends Constraint
{
    public $message = 'The Chasis Number "{{ string }}" is not in the correct format. Try something like VSF000AAAAA123456';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties
}
