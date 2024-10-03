<?php declare(strict_types=1);

namespace F5\CatFacts\Api;

use Magento\Framework\HTTP\Client\Curl;
use Laminas\Http\Client;
use Laminas\Http\ClientFactory;
use Laminas\Http\Request;
use Laminas\Http\RequestFactory;
use Laminas\Uri\UriFactory;

class CatFactsApi
{
    public const API_URL = 'https://catfact.ninja/fact';

    public function __construct(
        private ClientFactory $client,
        private RequestFactory $requestFactory,
        private Curl $curl
    )
    {
    }

    /**
     * @throws \JsonException
     */
    public function getCatFact($method = null): string
    {
        if ($method == 'CURL') {
           return $this->getCatFactUsingCurl();
        }
        else {
          return $this->getCatFactUsingLaminas();
        }
    }

    private function getCatFactUsingLaminas(): string
    {
        $request = $this->requestFactory->create();
        $request->setUri(self::API_URL);

        $client = $this->client->create();
        try {
            $response = $client->send($request);
            $responseBody = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception|\JsonException $e) {
            echo 'Could not retrieve a cat fact!: ', $e->getMessage(), PHP_EOL;
        }
        return $responseBody['fact'] ?? 'Could not retrieve a cat fact!';
    }

    /**
     * Fetch a random cat fact from the API.
     *
     * @return string
     * @throws \JsonException
     */
    private function getCatFactUsingCurl(): string
    {
        $this->curl->get(self::API_URL);
        $response = json_decode($this->curl->getBody(), true, 512, JSON_THROW_ON_ERROR);
        return $response['fact'] ?? 'Could not retrieve a cat fact!';
    }
}
