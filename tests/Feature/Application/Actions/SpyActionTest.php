<?php

namespace Application\Actions;

use App\Application\Actions\CreateSpyAction;
use App\Application\Actions\GetRandomSpiesAction;
use App\Application\DTOs\Spy\CreateSpyDTO;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpyActionTest extends TestCase
{
    use refreshDatabase;

    private CreateSpyAction $createSpyAction;
    private GetRandomSpiesAction $getRandomSpiesAction;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->createSpyAction = $this->app->make(CreateSpyAction::class);
        $this->getRandomSpiesAction = $this->app->make(GetRandomSpiesAction::class);
    }

    public function test_it_creates_spy_successfully()
    {
        $dto = new CreateSpyDTO(
            firstName: 'Annie',
            lastName: 'Hath',
            agency: Agency::MI6->value,
            countryOfOperation: 'United Kingdom',
            dateOfBirth: '1971-12-11'
        );

        $this->createSpyAction->execute($dto);

        $this->assertDatabaseHas('spies', [
            'first_name' => 'Annie',
            'last_name' => 'Hath'
        ]);

    }

    public function test_it_gets_random_spies()
    {
        $this->createTestSpies();
        $randomSpies = $this->getRandomSpiesAction->execute(3);

        $this->assertCount(3, $randomSpies);
        $this->assertContainsOnlyInstancesOf(Spy::class, $randomSpies);

    }

    public function test_it_allows_maximum_ten_requests_per_minute(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $response = $this->getJson('/api/spies/random');
            $response->assertSuccessful();
        }

        $response = $this->getJson('/api/spies/random');
        $response->assertStatus(429);
    }

    private function createTestSpies(): void
    {
        $spies = [
            ['John', 'Doe', Agency::MI6, 'Ukraine'],
            ['Ahmed', 'Abad', Agency::CIA, 'United Arab Emirates'],
            ['George', 'Karalis', Agency::CIA, 'Greece'],
            ['Natasha', 'Romanoff', Agency::KGB, 'Russia'],
            ['Jack', 'Ryan', Agency::CIA, 'United States'],
        ];

        foreach ($spies as [$firstName, $lastName, $agency, $country]) {
            $dto = new CreateSpyDTO(
                firstName: $firstName,
                lastName: $lastName,
                agency: $agency->value,
                countryOfOperation: $country,
                dateOfBirth: '1970-01-01'
            );

            $this->createSpyAction->execute($dto);
        }
    }
}
