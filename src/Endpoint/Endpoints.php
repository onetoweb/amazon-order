<?php

namespace Onetoweb\AmazonOrder\Endpoint;

/**
 * Endpoints.
 */
final class Endpoints
{
    /**
     * @return array
     */
    public static function list(): array
    {
        $endpoints = [];
        
        $dir = __DIR__ . '/Endpoints/';
        
        foreach (scandir($dir) as $filename) {
            
            $path = $dir.$filename;
            
            if (is_file($path) and !in_array($filename, ['.', '..'])) {
                
                $endpoint = pathinfo($filename, PATHINFO_FILENAME);
                
                $class = __NAMESPACE__ . "\\Endpoints\\$endpoint";
                
                if (is_a($class, EndpointInterface::class, true)) {
                    $endpoints[lcfirst($endpoint)] = $class;
                }
            }
        }
        
        return $endpoints;
    }
}