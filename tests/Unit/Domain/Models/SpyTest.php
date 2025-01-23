<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models;

use App\Domain\Events\SpyCreatedEvent;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SpyTest extends TestCase
{
    private Name $name;
    private Agency $agency;
    private string $countryOfOperation;
    private Date $dateOfBirth;
    private ?Date $dateOfDeath;
    private $id;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->name = $this->createMock(Name::class);
        $this->agency = Agency::MI6;
        $this->countryOfOperation = 'United Kingdom';
        $this->dateOfBirth = $this->createMock(Date::class);
        $this->dateOfDeath = null;
    }

    #[Test]
    public function should_create_spy(): void
    {
        $spy = new Spy(
            $this->name,
            $this->agency,
            $this->countryOfOperation,
            $this->dateOfBirth,
            $this->id,
            $this->dateOfDeath
        );

        $this->assertInstanceOf(Spy::class, $spy);
        $this->assertSame($this->name, $spy->getName());
        $this->assertSame($this->agency, $spy->getAgency());
        $this->assertSame($this->countryOfOperation, $spy->getCountryOfOperation());
        $this->assertSame($this->dateOfBirth, $spy->getDateOfBirth());
        $this->assertNull($spy->getDateOfDeath());
    }

    #[Test]
    public function should_add_domain_event_when_created_via_factory(): void
    {
        $spy = Spy::create(
            $this->name,
            $this->agency,
            $this->countryOfOperation,
            $this->dateOfBirth,
            $this->dateOfDeath
        );

        $events = $spy->pullDomainEvents();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(SpyCreatedEvent::class, $events[0]);
    }

    #[Test]
    public function should_clear_events_after_pulling(): void
    {
        $spy = Spy::create(
            name: $this->name,
            agency: $this->agency,
            countryOfOperation: $this->countryOfOperation,
            dateOfBirth: $this->dateOfBirth,
            dateOfDeath: $this->dateOfDeath
        );

        // first pull get events
        $firstPull = $spy->pullDomainEvents();
        $this->assertCount(1, $firstPull);

        // second pull should be empt
        $secondPull = $spy->pullDomainEvents();
        $this->assertEmpty($secondPull);
    }

    #[Test]
    /**
     * @throws Exception
     */
    public function should_handle_death_date_when_provided(): void
    {
        $deathDate = $this->createMock(Date::class);

        $spy = new Spy(
            $this->name,
            $this->agency,
            $this->countryOfOperation,
            $this->dateOfBirth,
            $this->id,
            $deathDate
        );

        $this->assertSame($deathDate, $spy->getDateOfDeath());
    }
}
