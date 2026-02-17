<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Order 2026 Endpoint.
 */
class Order2026 extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array|NULL
     */
    public function search(array $query = []): ?array
    {
        return $this->client->get('/orders/2026-01-01/orders', $query);
    }
    
    /**
     * @param string $orderId
     * @param array $query = []
     * 
     * @return array|null
     */
    public function get(string $orderId, array $query = []): ?array
    {
        return $this->client->get("/orders/2026-01-01/orders/$orderId", $query);
    }
}
