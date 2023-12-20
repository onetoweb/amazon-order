<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Listing Endpoint.
 */
class Listing extends AbstractEndpoint
{
    /**
     * @param string $sellerId
     * @param string $sku
     * @param array $query = []
     * 
     * @return array|null
     */
    public function getItem(string $sellerId, string $sku, array $query = []): ?array
    {
        return $this->client->get("/listings/2021-08-01/items/$sellerId/".urlencode($sku), $query);
    }
    
    /**
     * @param string $sellerId
     * @param string $sku
     * @param array $query = []
     * @param array $data = []
     * 
     * @return array|null
     */
    public function patchItem(string $sellerId, string $sku, array $query = [], array $data = []): ?array
    {
        return $this->client->patch("/listings/2021-08-01/items/$sellerId/".urlencode($sku), $data, $query);
    }
    
    /**
     * @param string $sellerId
     * @param string $sku
     * @param array $query = []
     * 
     * @return array|null
     */
    public function deleteItem(string $sellerId, string $sku, array $query = []): ?array
    {
        return $this->client->delete("/listings/2021-08-01/items/$sellerId/".urlencode($sku), $query);
    }
}