<?php

namespace Onetoweb\AmazonOrder\Endpoint\Endpoints;

use Onetoweb\AmazonOrder\Endpoint\AbstractEndpoint;

/**
 * Report Endpoint.
 */
class Report extends AbstractEndpoint
{
    /**
     * @param array $query = []
     * 
     * @return array|null
     */
    public function list(array $query = []): ?array
    {
        return $this->client->get('/reports/2021-06-30/reports', $query);
    }
    
    /**
     * @param string $reportId
     * 
     * @return array|null
     */
    public function get(string $reportId): ?array
    {
        return $this->client->get("/reports/2021-06-30/reports/$reportId");
    }
    
    /**
     * @param array $data
     * 
     * @return array|null
     */
    public function create(array $data): ?array
    {
        return $this->client->post('/reports/2021-06-30/reports', $data);
    }
    
    /**
     * @param string $documentId
     * 
     * @return array|null
     */
    public function document(string $documentId): ?array
    {
        return $this->client->get("/reports/2021-06-30/documents/$documentId");
    }
}
