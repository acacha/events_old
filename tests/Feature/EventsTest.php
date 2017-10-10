<?php

namespace Tests\Feature;

use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group todo
     *
     * @test
     */
    public function testShowAllEvents()
    {
        // 3 parts

        // 1) Preparo el test
        // 2) Executo el codi que vull provar
        // 3) Comprovo: assert

        $events = factory(Event::class,50)->create();

        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('list_events');
        // TODO Contar que hi ha 50 al resultat

        foreach ($events as $event) {
            $response->assertSeeText($event->name);
            $response->assertSeeText($event->description);
        }
    }

    /**
     *
     */
    public function testShowAnEvent()
    {
        // Preparo
        $event = factory(Event::class)->create();
        // Executo
        $response = $this->get('/events/' . $event->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('show_event');
        $response->assertViewHas('event');

        $response->assertSeeText($event->name);
        $response->assertSeeText($event->description);
        $response->assertSeeText('Event');

    }

    /**
     * @group todo1
     */
    public function testNotShowAnEvent()
    {

        // Executo
        $response = $this->get('/events/9999999');
        // Comprovo
        $response->assertStatus(404);

    }
}
