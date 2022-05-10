<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidIdCardValidator extends ConstraintValidator
{

    public function checkIdCardCharacter($value): bool
    {
        $character = substr($value, -1);
        $numbers = substr($value, 0, -1);

        if (!is_numeric($numbers)) {
            return false;
        }

        if (!(substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) ==
            $character && strlen($character) == 1 && strlen ($numbers) == 8 )){
            return false;
        }

        return true;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidIdCard) {
            throw new UnexpectedTypeException($constraint, ValidIdCard::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        // access your configuration options like this:
        if ('strict' === $constraint->mode) {
            // ...
        }

        if (!preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        if(!$this->checkIdCardCharacter($value)){
            $this->context->buildViolation($constraint->message2)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
