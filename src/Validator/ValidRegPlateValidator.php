<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidRegPlateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidRegPlate) {
            throw new UnexpectedTypeException($constraint, ValidRegPlate::class);
        }

        if (null === $value || '' === $value) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!is_string($value)) {

            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[0-9]{4}[BCDFGHJKLMNPQRSTVWXZ]{3}$/i', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

}
