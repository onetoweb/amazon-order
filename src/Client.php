<?php

namespace Onetoweb\AmazonOrder;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use Onetoweb\AmazonOrder\Exception\{UnknownRegionException, TokenException, RestrictedDataException};
use Onetoweb\AmazonOrder\Endpoint\Endpoints;
use Onetoweb\AmazonOrder\Token;
use DateTime;

/**
 * Amazon Order Api Client.
 */
#[\AllowDynamicProperties]
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
     * @var float
     */
    private $rateLimit;
    
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
     * @return float|null
     */
    public function getRateLimit(): ?float
    {
        return $this->rateLimit;
    }
    
    /**
     * @param string $path
     * @param array $query = []
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function get(string $path, array $query = [], array $restrictedDataElements = []): ?array
    {
        $restrictedDataToken = $this->getRestrictedDataToken(self::METHOD_GET, $path, $restrictedDataElements);
        
        return $this->request(self::METHOD_GET, $path, $query, [], $restrictedDataToken);
    }
    
    /**
     * @param string $path
     * @param array $data = []
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function post(string $path, array $data = [], array $restrictedDataElements = []): ?array
    {
        $restrictedDataToken = $this->getRestrictedDataToken(self::METHOD_POST, $path, $restrictedDataElements);
        
        return $this->request(self::METHOD_POST, $path, [], $data, $restrictedDataToken);
    }
    
    /**
     * @param string $path
     * @param array $data = []
     * @param array $query = []
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function put(string $path, array $data = [], array $query = [], array $restrictedDataElements = []): ?array
    {
        $restrictedDataToken = $this->getRestrictedDataToken(self::METHOD_PUT, $path, $restrictedDataElements);
        
        return $this->request(self::METHOD_PUT, $path, $query, $data, $restrictedDataToken);
    }
    
    /**
     * @param string $path
     * @param array $data = []
     * @param array $query = []
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function patch(string $path, array $data = [], array $query = [], array $restrictedDataElements = []): ?array
    {
        $restrictedDataToken = $this->getRestrictedDataToken(self::METHOD_PATCH, $path, $restrictedDataElements);
        
        return $this->request(self::METHOD_PATCH, $path, $query, $data, $restrictedDataToken);
    }
    
    /**
     * @param string $path
     * @param array $query = []
     * @param array $restrictedDataElements = []
     * 
     * @return array|null
     */
    public function delete(string $path, array $query = [], array $restrictedDataElements = []): ?array
    {
        $restrictedDataToken = $this->getRestrictedDataToken(self::METHOD_DELETE, $path, $restrictedDataElements);
        
        return $this->request(self::METHOD_DELETE, $path, $query, [], $restrictedDataToken);
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
     * @param string $path
     * @param array $dataElements = []
     * 
     * @throws RestrictedDataException if access to restricted data elements is denied
     * 
     * @return Token|null
     */
    public function getRestrictedDataToken(string $method, string $path, array $dataElements = [])
    {
        if (count($dataElements) > 0) {
            
            // restricted data token request
            $results = $this->post('/tokens/2021-03-01/restrictedDataToken', [
                'restrictedResources' => [[
                    'method' => $method,
                    'path' => $path,
                    'dataElements' => $dataElements
                ]]
            ]);
            
            if (isset($results['errors'][0]['message'])) {
                throw new RestrictedDataException($results['errors'][0]['message']);
            }
            
            if (
                isset($results['expiresIn'])
                and isset($results['restrictedDataToken'])
            ) {
                
                // get expires datetime
                $expiresIn = ((int) $results['expiresIn'] - 10);
                $expires = (new DateTime())->modify("+$expiresIn seconds");
                
                // return restricted data token
                return new Token($results['restrictedDataToken'], $expires);
            }
        }
        
        return null;
    }
    
    /**
     * @param string $scope = null
     * 
     * @throws TokenException if fetching grantless token fails
     * 
     * @return Token
     */
    public function getGrantlessToken(string $scope): Token
    {
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            ],
            RequestOptions::QUERY => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => $scope
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
        
        // return grantless token
        return new Token($tokenArray['access_token'], $expires);
    }
    
    /**
     * @param string $method
     * @param string $path
     * @param array $query = []
     * @param array $data = []
     * @param Token $restrictedDataToken = null
     * 
     * @return array|null
     */
    public function request(string $method, string $path, array $query = [], array $data = [], Token $restrictedDataToken = null): ?array
    {
        // check token
        if (
            $restrictedDataToken === null
            and (
                $this->token === null
                or $this->token->isExpired()
            )
        ) {
            $this->getAccessToken();
        }
        
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'user-agent' => 'Onetoweb (Language=PHP/'.phpversion().'; Platform='.PHP_OS.')',
                'content-type' => 'application/json; charset=utf-8',
                'x-amz-access-token' => (string) ($restrictedDataToken !== null ? $restrictedDataToken : $this->token),
                'x-amz-date' => (new DateTime())->format(self::X_AMZ_DATE_HEADER_FORMAT),
            ],
            RequestOptions::QUERY => $query,
        ];
        
        // add json body
        if (in_array($method, [self::METHOD_POST, self::METHOD_PUT, self::METHOD_PATCH])) {
            $options[RequestOptions::JSON] = $data;
        }
        
        // request
        $response = (new GuzzleCLient())->request($method, $this->baseUrl . $path, $options);
        
        // set rate limit
        $this->rateLimit = (float) $response->getHeaderLine('x-amzn-RateLimit-Limit');
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // json decode
        $data = json_decode($contents, true);
        
        // return data
        return $data;
    }
}