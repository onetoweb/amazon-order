<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Finance Endpoint.
 */
class Finance extends AbstractEndpoint
{
    /**
     * @return array|null
     */
    public function getEventsByOrderId(string $orderId): ?array
    {
        return $this->client->get("/finances/v0/orders/$orderId/financialEvents");
    }
}