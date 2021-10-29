<?php

namespace App\Repository;

use App\Exceptions\PokemonApiException;
use App\Exceptions\ShakespearApiException;
use App\Http\Resources\PokemonResource;
use App\Services\PokemonApiRetrieverService;
use App\Services\ShakespeareanApiDescriptionService;
use Illuminate\Support\Facades\Cache;
// PokemonRepository retrieve data using API and Redis Cache
class PokemonRepository
{
    private PokemonApiRetrieverService $pokeApi;
    private ShakespeareanApiDescriptionService $shakespeareanApiDescriptionService;

    /**
     * @param PokemonApiRetrieverService $pokeApi
     * @param ShakespeareanApiDescriptionService $shakespeareanApiDescriptionService
     */
    public function __construct(PokemonApiRetrieverService $pokeApi, ShakespeareanApiDescriptionService $shakespeareanApiDescriptionService)
    {
        $this->pokeApi = $pokeApi;
        $this->shakespeareanApiDescriptionService = $shakespeareanApiDescriptionService;
    }

    /**
     * @param string $pokemonName
     * @return ?array
     */
    public function getPokemon(string $pokemonName): ?PokemonResource
    {
        return Cache::remember($pokemonName, 60 * 24 * 24, function () use ($pokemonName) {
            return $this->getUncachedPokemonFromAPI($pokemonName);
        });
    }

    /**
     * @param string $pokemonName
     * @return PokemonResource
     * @throws PokemonApiException
     * @throws ShakespearApiException
     */
    public function getUncachedPokemonFromAPI(string $pokemonName): PokemonResource
    {
        $pokemon = $this->pokeApi->getPokemon($pokemonName);

        $pokemonDescription = $this->pokeApi->getPokemonDescription($pokemon->getId());

        $shakespeareanDescription = $this->shakespeareanApiDescriptionService
            ->getShakespeareanDescription($pokemonDescription);

        return new PokemonResource([
            'name' => $pokemon->getName(),
            'description' => $shakespeareanDescription,
            'sprite' => $pokemon->getSprite()
        ]);
    }
}
