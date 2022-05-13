<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidNumChasisValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidNumChasis) {
            throw new UnexpectedTypeException($constraint, ValidNumChasis::class);
        }

        if (null === $value || '' === $value) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!is_string($value)) {

            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Z0-9]{17}$/i', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

}
