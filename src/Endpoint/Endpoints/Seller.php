<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Seller Endpoint.
 */
class Seller extends AbstractEndpoint
{
    /**
     * @return array|null
     */
    public function marketplaceParticipations(): ?array
    {
        return $this->client->get('/sellers/v1/marketplaceParticipations');
    }
}
