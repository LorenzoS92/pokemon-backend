<?php

namespace Tests\Unit;

use App\Exceptions\ShakespearApiException;
use App\Services\ShakespeareanApiDescriptionService;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ShakespeareanApiDescriptionTest extends TestCase
{
    private ShakespeareanApiDescriptionService $pokemonShakespeareanDescription;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pokemonShakespeareanDescription = new ShakespeareanApiDescriptionService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }


    /**
     * @throws HttpClientException
     */
    public function test_getShakespeareanDescriptionSuccessfully()
    {
        $happyPathJson = file_get_contents("storage/tests/Json/shakespeare-api-test.json");

        Http::fake(['http://api.funtranslations.com/translate/shakespeare' => Http::response($happyPathJson, 200)]);

        $actualDescription = $this->pokemonShakespeareanDescription->getShakespeareanDescription("fake");
        $expectedDescription = "fakeS";

        $this->assertEquals($expectedDescription, $actualDescription);
    }

    public function test_getShakespeareanDescriptionWithException()
    {
        $this->expectException(ShakespearApiException::class);
        $errorJson = file_get_contents("storage/tests/Json/shakespeare-api-test-error.json");

        Http::fake(['http://api.funtranslations.com/translate/shakespeare' => Http::response($errorJson, 200)]);

        $this->pokemonShakespeareanDescription->getShakespeareanDescription("fake");
    }

    public function test_getShakespeareanDescriptionWithHttp404Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['http://api.funtranslations.com/translate/shakespeare' => Http::response(null, 404)]);

        $this->pokemonShakespeareanDescription->getShakespeareanDescription("fake");
    }

    public function test_getShakespeareanDescriptionWithHttp500Exception()
    {
        $this->expectException(HttpException::class);

        Http::fake(['http://api.funtranslations.com/translate/shakespeare' => Http::response(null, 500)]);

        $this->pokemonShakespeareanDescription->getShakespeareanDescription("fake");
    }

    public function provideResponseData(): array
    {
        $happyPathJson = file_get_contents("storage/tests/Json/shakespeare-api-test.json");
        $errorJson = file_get_contents("storage/tests/Json/shakespeare-api-test-error.json");

        return [
            [
                $happyPathJson,
                "fakeS",
                false
            ],
            [
                $errorJson,
                null,
                true
            ],
        ];
    }
}
