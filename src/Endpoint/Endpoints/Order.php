<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Order Endpoint.
 */
class Order extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array|null
     */
    public function search(array $query = []): ?array
    {
        return $this->client->get('/orders/v0/orders', $query);
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function get(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId");
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function getBuyerInfo(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/buyerInfo");
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function getAddress(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/address");
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function getItems(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/orderItems");
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function getItemBuyerInfo(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/orderItems/buyerInfo");
    }
    
    /**
     * @param string $orderId
     * 
     * @return array|null
     */
    public function getRegulatedInfo(string $orderId): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/regulatedInfo");
    }
}