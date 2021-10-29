<?php

namespace App\Services;

use App\Exceptions\ShakespearApiException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShakespeareanApiDescriptionService
{
    /**
     * @throws HttpException
     * @throws ShakespearApiException
     */
    public function getShakespeareanDescription(string $englishDescription): string
    {
        $response = Http::post(config('endpoints.shakespeare_api'), [
            'text' => $englishDescription
        ]);

        if (!$response->successful()) {
            throw new HttpException($response->status(), "Unable to retrieve shakespeare description");
        }

        $responseJson = $response->json();
        if (!isset($responseJson["contents"]["translated"])) {
            throw new ShakespearApiException("Unable to parse response for shakespeare description");
        }
        return $responseJson["contents"]["translated"];
    }
}
