<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getPokemon()
    {
        $response = $this->get('/api/pokemon/pikachu');

        $response
            ->assertStatus(200)
            ->assertJson([
                "name" => "Pikachu",
                "description" => "Likes to relax",
                "sprite" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png"
            ]);
    }

    public function test_pokemonNotFound()
    {
        $response = $this->get('/api/pokemon/unabletofoundpokemon');

        $response
            ->assertStatus(404);
    }
}
