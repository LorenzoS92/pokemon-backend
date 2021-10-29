<?php

namespace Tests\Unit;

use App\Exceptions\PokemonApiException;
use App\Services\PokemonApi;
use App\Services\PokemonApiRetrieverService;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use Mockery;
use PokePHP\PokeApi;

class PokemonApiRetrieverTest extends TestCase
{
    protected PokemonApiRetrieverService $pokemonRetrieverService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pokemonRetrieverService = new PokemonApiRetrieverService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_getPokemonSuccessfully()
    {
        $happyPathJson = file_get_contents("storage/tests/Json/pokemon-api-test.json");

        Http::fake(['https://pokeapi.co/api/v2/pokemon-form/charizard' => Http::response($happyPathJson, 200)]);

        $actualResult = $this->pokemonRetrieverService->getPokemon("charizard");
        $expectedResult = new PokemonApi(
            6,
            'Charizard',
            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png'
        );

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_getPokemonDescriptionSuccessfully()
    {
        $happyPathJson = file_get_contents("storage/tests/Json/pokemon-characteristic-api-test.json");

        Http::fake(['https://pokeapi.co/api/v2/characteristic/6' => Http::response($happyPathJson, 200)]);

        $actualResult = $this->pokemonRetrieverService->getPokemonDescription(6);
        $expectedResult = "Likes to run";

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_getPokemonHttp404Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['https://pokeapi.co/api/v2/pokemon-form/charizard' => Http::response(null, 404)]);

        $this->pokemonRetrieverService->getPokemon("charizard");

    }

    public function test_getPokemonHttp500Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['https://pokeapi.co/api/v2/pokemon-form/charizard' => Http::response(null, 500)]);

        $this->pokemonRetrieverService->getPokemon("charizard");

    }

    public function test_getPokemonDescriptionHttp404Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['https://pokeapi.co/api/v2/characteristic/6' => Http::response(null, 404)]);

        $this->pokemonRetrieverService->getPokemonDescription(6);

    }

    public function test_getPokemonDescriptionHttp500Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['https://pokeapi.co/api/v2/characteristic/6' => Http::response(null, 500)]);

        $this->pokemonRetrieverService->getPokemonDescription(6);

    }

    public function test_getPokemonException()
    {
        $this->expectException(PokemonApiException::class);
        $errorJson = file_get_contents("storage/tests/Json/pokemon-api-test-error.json");


        Http::fake(['https://pokeapi.co/api/v2/pokemon-form/charizard' => Http::response($errorJson, 200)]);

        $this->pokemonRetrieverService->getPokemon("charizard");
    }
}
