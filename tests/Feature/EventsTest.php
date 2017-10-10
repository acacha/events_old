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

        // 1) Preparo el test
        $events = factory(Event::class,50)->create();
        // 2) Executo el codi que vull provar
        $response = $this->get('/events');

        // 3) Comprovo: assert
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

    public function testShowCreateEventForm()
    {
        // Preparo
        // Executo
        $response = $this->get('/events/create');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('create_event');
        $response->assertSeeText('Create Event');
    }

    public function testShowEditEventForm()
    {
        // Preparo
        // Executo
        $response = $this->get('/events/edit');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('edit_event');
        $response->assertSeeText('Edit Event');
    }

    public function testStoreEventForm()
    {
        // Preparo
        $event = factory(Event::class)->make();
        // Executo
        $response = $this->post('/events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);
        // Comprovo
        $response->assertStatus(200);
        $response->assertRedirect('events/create');
        $response->assertSeeText('Created ok!');

        $this->assertDatabaseHas('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);
    }

    public function testUpdateEventForm()
    {
        // Preparo
        $event = factory(Event::class)->create();
        // Executo
        $newEvent = factory(Event::class)->make();
        $response = $this->patch('/events/' . $event->id,[
            'name' => $newEvent->name,
            'description' => $newEvent->description,
        ]);
        // Comprovo
        $response->assertStatus(200);
        $response->assertRedirect('events/create');
        $response->assertSeeText('Edited ok!');

        $this->assertDatabaseHas('events',[
            'id' =>  $event->id,
            'name' => $newEvent->name,
            'description' => $newEvent->description,
        ]);

        $this->assertDatabaseMissing('events',[
            'id' =>  $event->id,
            'name' => $event->name,
            'description' => $event->description,
        ]);
    }

    public function testDeleteEvent()
    {
        // Preparo
        $event = factory(Event::class)->create();
        // Executo
        $response = $this->delete('/events/' . $event->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertRedirect('events');
        $response->assertSeeText('Deleted ok!');

        $this->assertDatabaseMissing('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);
    }
}
