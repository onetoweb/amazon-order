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
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function search(array $query = [], array $restrictedDataElements = []): ?array
    {
        return $this->client->get('/orders/v0/orders', $query, $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function get(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function getBuyerInfo(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/buyerInfo", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function getAddress(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/address", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function getItems(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/orderItems", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function getItemBuyerInfo(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/orderItems/buyerInfo", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function getRegulatedInfo(string $orderId, array $restrictedDataElements = []): ?array
    {
        return $this->client->get("/orders/v0/orders/$orderId/regulatedInfo", [], $restrictedDataElements);
    }
    
    /**
     * @param string $orderId
     * @param array $data = []
     * 
     * @return array|null
     */
    public function createShipmentConfirmation(string $orderId, array $data = []): ?array
    {
        return $this->client->post("/orders/v0/orders/$orderId/shipmentConfirmation", $data);
    }
}