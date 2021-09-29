<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListAllOfficesWithPagination()
    {
        $this->withoutExceptionHandling();

        Office::factory(3)->create();

        $response = $this->get('/api/offices');

        //dd($response);

        $response->assertOk()->dump();
        $response->assertJsonCount(20, 'data');
        $this->assertNotNull($response->json('data')[0]['id']);
        $this->assertNotNull($response->json('links'));

    }

    public function testThatItReturnsOnlyOfficesThatAreNotHiddenAndAreApproved()
    {
        Office::factory()->create();

        Office::factory()->create(['hidden' => true ]);

        Office::factory()->create(['approval_status' => Office::APPROVAL_PENDING]);

        $response = $this->get('/api/offices');

        $response->assertOk()->dump();
        $response->assertJsonCount(20, 'data');

    }

    public function testItFiltersByHostId()
    {
        Office::factory(3)->create();

        $host = User::factory()->create();

        $office = Office::factory()->for($host)->create();

        $response = $this->get('/api/offices?host_id='. $host->id);

        ddd($response);

        $response->assertOk()->dump();
        $response->assertJsonCount(1, 'data');
        $this->assertEmpty($office->id, $response->json('data')[0]['id']);

    }
}
