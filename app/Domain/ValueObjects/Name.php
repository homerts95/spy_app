<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

/**
 *
 */
readonly class Name
{
    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(
        private string $firstName,
        private string $lastName
    ) {
        if (empty(trim($firstName)) || empty(trim($lastName))) {
            throw new InvalidArgumentException('First name and last name cannot be empty');
        }
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
