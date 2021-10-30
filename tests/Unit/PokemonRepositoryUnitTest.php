<?php

namespace Tests\Feature;

use App\Http\Resources\PokemonResource;
use App\Repository\PokemonRepository;
use App\Services\PokemonApi;
use App\Services\PokemonApiRetrieverService;
use App\Services\ShakespeareanApiDescriptionService;
use Mockery;
use Tests\TestCase;

class PokemonRepositoryUnitTest extends TestCase
{
    private ShakespeareanApiDescriptionService|Mockery\LegacyMockInterface|Mockery\MockInterface $shakespeareanApiDescription;
    private PokemonApiRetrieverService|Mockery\LegacyMockInterface|Mockery\MockInterface $pokemonRetrieverService;
    private PokemonRepository $pokemonRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pokemonRetrieverService = Mockery::mock(PokemonApiRetrieverService::class);
        $this->shakespeareanApiDescription = Mockery::mock(ShakespeareanApiDescriptionService::class);
        $this->pokemonRepository = new PokemonRepository(
            $this->pokemonRetrieverService,
            $this->shakespeareanApiDescription
        );
    }

    /**
     * @throws \App\Exceptions\ShakespearApiException
     * @throws \App\Exceptions\PokemonApiException
     */
    public function test_getPokemonUnCached()
    {
        $gotPokemonApiResponse = new PokemonApi(
            6,
            'charizard',
            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png'
        );
        $gotPokemonDescription = "it flies";
        $gotShakespeareanDescription = "shakespearean it flies";


        $expectedPokemonResource = new PokemonResource([
            'name' => 'charizard',
            'description' => $gotShakespeareanDescription,
            'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png'
        ]);

        $this->pokemonRetrieverService->shouldReceive('getPokemon')->andReturn($gotPokemonApiResponse);
        $this->pokemonRetrieverService->shouldReceive('getPokemonDescription')->andReturn($gotPokemonDescription);
        $this->shakespeareanApiDescription->shouldReceive('getShakespeareanDescription')->andReturn($gotShakespeareanDescription);

        $pokemonResource = $this->pokemonRepository->getUncachedPokemonFromAPI("charizard");

        $this->assertEquals($expectedPokemonResource, $pokemonResource);
    }
}
