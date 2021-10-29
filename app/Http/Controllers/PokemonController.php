<?php

namespace App\Http\Controllers;

use App\Http\Resources\PokemonResource;
use App\Repository\PokemonRepository;

/**
 * @group Pokemon
 *
 * API endpoints to get Pokemon
 */
class PokemonController extends Controller
{
    /**
     * Retrieve a Pokemon by calling external APIs or retrieve it from Redis
     *
     *
     * @response {
     *  "name": "Pikachu",
     *  "description": "It relaxes",
     *  "sprite": "url",
     * }
     */
    public function index(string $pokemonName, PokemonRepository $pokemonRepository): PokemonResource|array|null
    {
        return $pokemonRepository->getPokemon($pokemonName);
    }
}
