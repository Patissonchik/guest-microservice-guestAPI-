<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Guest;

class GuestTest extends TestCase
{
    //use RefreshDatabase;

    /** @test */
    public function it_can_create_a_guest()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john9.doe@example.com',
            'phone' => '+79882234567',
        ];

        $response = $this->postJson('/api/guests', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'first_name' => 'John',
                     'last_name' => 'Doe',
                     'email' => 'john9.doe@example.com',
                     'phone' => '+79882234567',
                     'country' => 'RU'
                 ]);

        $this->assertDatabaseHas('guests', $data);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_a_guest()
    {
        $response = $this->postJson('/api/guests', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'phone']);
    }

    /** @test */
    public function it_validates_unique_email_and_phone_when_creating_a_guest()
    {
        $guest = Guest::factory()->create();

        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => $guest->email,
            'phone' => $guest->phone,
        ];

        $response = $this->postJson('/api/guests', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'phone']);
    }

    /** @test */
    public function it_returns_error_for_invalid_phone_number()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john4.doe@example.com',
            'phone' => 'invalid_phone',
        ];

        $response = $this->postJson('/api/guests', $data);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Некорректный номер телефона']);
    }

    /** @test */
    public function it_can_get_a_list_of_guests()
    {
        Guest::factory()->count(3)->create();

        $response = $this->getJson('/api/guests');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'first_name', 'last_name', 'email', 'phone', 'country', 'created_at', 'updated_at']
                 ]);
    }

    /** @test */
    public function it_can_get_a_single_guest()
    {
        $guest = Guest::factory()->create();

        $response = $this->getJson("/api/guests/{$guest->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $guest->id,
                     'first_name' => $guest->first_name,
                     'last_name' => $guest->last_name,
                     'email' => $guest->email,
                     'phone' => $guest->phone,
                     'country' => $guest->country
                 ]);
    }

    /** @test */
    public function it_can_update_a_guest()
    {
        $guest = Guest::factory()->create();

        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane3.doe@example.com',
            'phone' => '+19991534567',
            'country' => 'US'
        ];

        $response = $this->putJson("/api/guests/{$guest->id}", $data);

        $response->assertStatus(200)
                 ->assertJson($data);

        $this->assertDatabaseHas('guests', $data);
    }

    /** @test */
    public function it_can_delete_a_guest()
    {
        $guest = Guest::factory()->create();

        $response = $this->deleteJson("/api/guests/{$guest->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Guest deleted']);

        $this->assertDatabaseMissing('guests', ['id' => $guest->id]);
    }
}
