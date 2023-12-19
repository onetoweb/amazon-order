<?php

namespace Onetoweb\AmazonOrder;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use Onetoweb\AmazonOrder\Exception\{UnknownRegionException, TokenException};
use Onetoweb\AmazonOrder\Endpoint\Endpoints;
use Onetoweb\AmazonOrder\Token;
use DateTime;

/**
 * Amazon Order Api Client.
 */
class Client
{
    /**
     * Methods.
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    
    /**
     * Date formats.
     */
    public const X_AMZ_DATE_HEADER_FORMAT = 'Ymd\\THis\\Z';
    public const AMAZON_QUERY_DATE_FORMAT = 'Y-m-d\\TH:i:s';
    
    /**
     * Base urls.
     */
    public const BASE_URLS = [
        'us-east-1' => 'https://sellingpartnerapi-na.amazon.com',
        'eu-west-1' => 'https://sellingpartnerapi-eu.amazon.com',
        'us-west-2' => 'https://sellingpartnerapi-fe.amazon.com'
    ];
    
    /**
     * Auth url.
     */
    public const AUTH_URL = 'https://api.amazon.com/auth/o2/token';
    
    /**
     * @var string
     */
    private $clientId;
    
    /**
     * @var string
     */
    private $clientSecret;
    
    /**
     * @var string
     */
    private $refreshToken;
    
    /**
     * @var string
     */
    private $baseUrl;
    
    /**
     * @var callable
     */
    private $tokenUpdateCallback;
    
    /**
     * @var Token
     */
    private $token;
    
    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $refreshToken
     * @param string $region = 'eu-west-1'
     */
    public function __construct(string $clientId, string $clientSecret, string $refreshToken, string $region = 'eu-west-1')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
        $this->setRegion($region);
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @param string $region
     * 
     * @throws UnknownRegionException if region is unknown
     * 
     * @return void
     */
    public function setRegion(string $region): void
    {
        if (!isset(self::BASE_URLS[$region])) {
            throw new UnknownRegionException("unknown region: $region");
        }
        
        // set base url
        $this->baseUrl = self::BASE_URLS[$region];
    }
    
    /**
     * @param callable $tokenUpdateCallback
     * 
     * @return void
     */
    public function setTokenUpdateCallback(callable $tokenUpdateCallback): void
    {
        $this->tokenUpdateCallback = $tokenUpdateCallback;
    }
    
    /**
     * @param Token $token
     * 
     * @return void
     */
    public function setToken(Token $token): void
    {
        $this->token = $token;
    }
    
    /**
     * @return Token
     */
    public function getToken(): Token
    {
        return $this->token;
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return array|null
     */
    public function get(string $endpoint, array $query = []): ?array
    {
        return $this->request(self::METHOD_GET, $endpoint, $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array|null
     */
    public function post(string $endpoint, array $data = []): ?array
    {
        return $this->request(self::METHOD_POST, $endpoint, [], $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array|null
     */
    public function put(string $endpoint, array $data = [], array $query = []): ?array
    {
        return $this->request(self::METHOD_PUT, $endpoint, $query, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array|null
     */
    public function patch(string $endpoint, array $data = [], array $query = []): ?array
    {
        return $this->request(self::METHOD_PATCH, $endpoint, $query, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return array|null
     */
    public function delete(string $endpoint, array $query = []): ?array
    {
        return $this->request(self::METHOD_DELETE, $endpoint, $query);
    }
    
    /**
     * @throws TokenException if fetching access token fails
     * 
     * @return void
     */
    public function getAccessToken(): void
    {
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            ],
            RequestOptions::QUERY => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refreshToken,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ];
        
        // request
        $response = (new GuzzleCLient())->post(self::AUTH_URL, $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // get token array
        $tokenArray = json_decode($contents, true);
        
        // throw token exception
        if (isset($tokenArray['error'])) {
            throw new TokenException($tokenArray['error_description'] ?? 'failed to get access token');
        }
        
        // get expires datetime
        $expiresIn = ((int) $tokenArray['expires_in'] - 10);
        $expires = (new DateTime())->modify("+$expiresIn seconds");
        
        // get refresh token
        $refreshToken = $tokenArray['refresh_token'] ?? null;
        
        // set token
        $this->token = new Token($tokenArray['access_token'], $expires);
        
        // token update callback
        if ($this->tokenUpdateCallback !== null) {
            ($this->tokenUpdateCallback)($this->token);
        }
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $query = []
     * @param array $data = []
     * 
     * @return array|null
     */
    public function request(string $method, string $endpoint, array $query = [], array $data = []): ?array
    {
        if ($this->token === null or $this->token->isExpired()) {
            $this->getAccessToken();
        }
        
        // build options
        $options = [
            RequestOptions::DEBUG => false,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'user-agent' => 'Onetoweb (Language=PHP/'.phpversion().'; Platform='.PHP_OS.')',
                'content-type' => 'application/json; charset=utf-8',
                'x-amz-access-token' => (string) $this->token,
                'x-amz-date' => (new DateTime())->format(self::X_AMZ_DATE_HEADER_FORMAT),
            ],
            RequestOptions::QUERY => $query,
        ];
        
        // add json body
        if (in_array($method, [self::METHOD_POST, self::METHOD_PUT, self::METHOD_PATCH])) {
            $options[RequestOptions::JSON] = $data;
        }
        
        // request
        $response = (new GuzzleCLient())->request($method, $this->baseUrl . $endpoint, $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // json decode
        $data = json_decode($contents, true);
        
        // return data
        return $data;
    }
}