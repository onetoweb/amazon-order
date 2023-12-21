<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Definition Endpoint.
 */
class Definition extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array|null
     */
    public function getProductTypes(array $query = []): ?array
    {
        return $this->client->get('/definitions/2020-09-01/productTypes', $query);
    }
    
    /**
     * @param string $productType
     * @param array $query = []
     * 
     * @return array|null
     */
    public function getProductType(string $productType, array $query = []): ?array
    {
        return $this->client->get("/definitions/2020-09-01/productTypes/$productType", $query);
    }
}