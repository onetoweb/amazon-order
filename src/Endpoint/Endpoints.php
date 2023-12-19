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
                
                if (class_exists($class) and in_array(EndpointInterface::class, class_implements($class))) {
                    $endpoints[lcfirst($endpoint)] = $class;
                }
            }
        }
        
        return $endpoints;
    }
}