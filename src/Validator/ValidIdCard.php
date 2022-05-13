<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidIdCard extends Constraint
{
    public $message = 'The ID Card "{{ string }}" is not in the correct format. Try something like 11111111A';
    public $message2= 'The ID Card Character it seems to be wrong';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties
}
