<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Catalog Endpoint.
 */
class Catalog extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array|null
     */
    public function searchItems(array $query = []): ?array
    {
        return $this->client->get('/catalog/2022-04-01/items', $query);
    }
}