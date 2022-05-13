<?php

namespace App\Validator;

use PhpParser\Node\Scalar\String_;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidIdCardValidator extends ConstraintValidator
{
    private $characterIdCard = "TRWAGMYFPDXBNJZSQVHLCKE";

    public function checkIdCardCharacter($value): bool
    {
        $character = substr($value, -1);
        $numbers = substr($value, 0, -1);

        if (!is_numeric($numbers)) {
            return false;
        }

        if (!(substr($this->characterIdCard, $numbers%23, 1) ==
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

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {

            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $value, $matches)) {

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
