<?php

namespace Ndewez\WebHome\CommonBundle\Service;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Validator.
 */
class Validator
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param mixed                   $value
     * @param Constraint|Constraint[] $constraints
     * @param array|null              $groups
     *
     * @return ConstraintViolationListInterface
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        return $this->validator->validate($value, $constraints, $groups);
    }

    /**
     * @param mixed                   $value
     * @param Constraint|Constraint[] $constraints
     * @param array|null              $groups
     *
     * @return array
     */
    public function validateToArray($value, $constraints = null, $groups = null)
    {
        return $this->formatViolationsToArray($this->validate($value, $constraints, $groups));
    }

    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return array
     */
    private function formatViolationsToArray(ConstraintViolationListInterface $violations)
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
