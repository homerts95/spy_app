<?php

namespace App\Domain\ValueObjects;

use DateTimeImmutable;

readonly class Date
{
    private DateTimeImmutable $value;

    /**
     * @throws \DateMalformedStringException
     */
    public function __construct(string $date)
    {
        $this->value = new DateTimeImmutable($date);
        if ($this->value > new DateTimeImmutable()) {
            throw new \InvalidArgumentException('Date cannot be in the future');
        }
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
