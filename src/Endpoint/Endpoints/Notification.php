<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Notification Endpoint.
 */
class Notification extends AbstractEndpoint
{
    /**
     * @param string $notificationType
     * @param array $query = []
     * 
     * @return array|null
     */
    public function list(string $notificationType, array $query = []): ?array
    {
        return $this->client->get("/notifications/v1/subscriptions/$notificationType", $query);
    }
    
    /**
     * @param string $notificationType
     * @param array $data = []
     * 
     * @return array|null
     */
    public function create(string $notificationType, array $data = []): ?array
    {
        return $this->client->post("/notifications/v1/subscriptions/$notificationType", $data);
    }
    
    /**
     * @param string $notificationType
     * @param string $subscriptionId
     *
     * @return array|null
     */
    public function get(string $notificationType, string $subscriptionId): ?array
    {
        return $this->client->get("/notifications/v1/subscriptions/$notificationType/$subscriptionId");
    }
    
    /**
     * @param string $notificationType
     * @param string $subscriptionId
     *
     * @return array|null
     */
    public function delete(string $notificationType, string $subscriptionId): ?array
    {
        return $this->client->delete("/notifications/v1/subscriptions/$notificationType/$subscriptionId");
    }
    
    /**
     * @param array $query = []
     * 
     * @return array|null
     */
    public function destinations(array $query = []): ?array
    {
        $grantlessToken = $this->client->getGrantlessToken('sellingpartnerapi::notifications');
        
        $this->client->setToken($grantlessToken);
        
        return $this->client->get('/notifications/v1/destinations', $query);
    }
    
    /**
     * @param string $destinationId
     * 
     * @return array|null
     */
    public function getDestination(string $destinationId): ?array
    {
        $grantlessToken = $this->client->getGrantlessToken('sellingpartnerapi::notifications');
        
        $this->client->setToken($grantlessToken);
        
        return $this->client->get("/notifications/v1/destinations/$destinationId");
    }
    
    /**
     * @param array $data = []
     * 
     * @return array|null
     */
    public function createDestination(array $data = []): ?array
    {
        $grantlessToken = $this->client->getGrantlessToken('sellingpartnerapi::notifications');
        
        $this->client->setToken($grantlessToken);
        
        return $this->client->post('/notifications/v1/destinations', $data);
    }
    
    /**
     * @param string $destinationId
     * 
     * @return array|null
     */
    public function deleteDestination(string $destinationId): ?array
    {
        $grantlessToken = $this->client->getGrantlessToken('sellingpartnerapi::notifications');
        
        $this->client->setToken($grantlessToken);
        
        return $this->client->delete("/notifications/v1/destinations/$destinationId");
    }
}
