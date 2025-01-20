<?php

namespace App\Domain\ValueObjects;

/**
 *
 */
enum Agency: string
{
    case CIA = 'CIA';
    case MI6 = 'MI6';
    case KGB = 'KGB';

    public function getFullName(): string
    {
        return match($this) {
            self::CIA => 'Central Intelligence Agency',
            self::MI6 => 'Military Intelligence, Section 6',
            self::KGB => 'Komitet Gosudarstvennoy Bezopasnosti'
        };
    }
}
