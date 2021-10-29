<?php

namespace App\Services;

use App\Exceptions\PokemonApiException;
use ErrorException;
use Exception;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use PokePHP\PokeApi;
use Symfony\Component\HttpKernel\Exception\HttpException;

// PokemonApiRetrieverService retrieve data using Pokemon SDK Api.
class PokemonApiRetrieverService
{
    public function __construct()
    {
    }

    /**
     * @param string $pokemonName the name of the Pokemon.
     * @throws HttpException
     * @throws PokemonApiException
     */
    public function getPokemon(string $pokemonName): ?PokemonApi
    {
        $pokemonName = strtolower($pokemonName);
        $pokemonResponse = Http::get(config('endpoints.pokemon_api') . "pokemon-form/$pokemonName");

        if (!$pokemonResponse->successful()) {
            throw new HttpException($pokemonResponse->status(), "Unable to retrieve pokemon from API");
        }

        $responseJson = $pokemonResponse->json();
        try {
            return new PokemonApi(
                (int)$responseJson['id'],
                ucfirst($responseJson['name']),
                $responseJson['sprites']['front_default'],
            );
        } catch (Exception) {
            throw new PokemonApiException("Unable to parse pokemon response");
        }
    }

    /**
     * @param int $pokemonID the id of the Pokemon.
     * @throws HttpException
     * @throws PokemonApiException
     */
    public function getPokemonDescription(int $pokemonID): string
    {
        $pokemonResponse = Http::get(config('endpoints.pokemon_api') . "characteristic/$pokemonID");

        if (!$pokemonResponse->successful()) {
            throw new HttpException($pokemonResponse->status(), "Unable to retrieve pokemon description from API");
        }

        $responseJson = $pokemonResponse->json();

        try {
            $descriptions = collect($responseJson['descriptions']);

            $englishPokemonDescription = $descriptions->filter(function ($pokemonLanguageDescription) {
                return $pokemonLanguageDescription["language"]["name"] === "en";
            });

            return $englishPokemonDescription->firstOrFail()["description"];

        } catch (Exception) {
            throw new PokemonApiException("Unable to parse pokemon description response");
        }
    }
}
