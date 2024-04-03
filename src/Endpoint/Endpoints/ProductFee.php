<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Product Fee Endpoint.
 */
class ProductFee extends AbstractEndpoint
{
    /**
     * @param string $asin
     * @param array $data
     * 
     * @return array
     */
    public function estimateByAsin(string $asin, array $data): array
    {
        return $this->client->post("/products/fees/v0/items/$asin/feesEstimate", [
            'FeesEstimateRequest' => $data
        ]);
    }
    
    /**
     * @param string $sku
     * @param array $data
     * 
     * @return array
     */
    public function estimateBySku(string $sku, array $data): array
    {
        return $this->client->post("/products/fees/v0/listings/$sku/feesEstimate", [
            'FeesEstimateRequest' => $data
        ]);
    }
}