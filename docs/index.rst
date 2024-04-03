.. title:: Index

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    session_start();
    
    use Onetoweb\AmazonOrder\{Client, Token};
    
    // params
    $region = 'eu-west-1';
    $clientId = 'client_id';
    $clientSecret = 'client_secret';
    $refreshToken = 'refresh_token';
    
    // setup client
    $client = new Client($clientId, $clientSecret, $refreshToken, $region);
    
    // load token from storage
    if (isset($_SESSION['token'])) {
        
        // build token
        $token = new Token(
            $_SESSION['token']['value'],
            $_SESSION['token']['expires']
        );
        
        // set token
        $client->setToken($token);
    }
    
    // setup token update callback
    $client->setTokenUpdateCallback(function(Token $token) {
        
        // store token
        $_SESSION['token'] = [
            'value' => $token->getValue(),
            'expires' => $token->getExpires(),
        ];
        
    });


========
Examples
========

* `Catalog <catalog.rst>`_
* `Definition <definition.rst>`_
* `Listing <listing.rst>`_
* `Order <order.rst>`_
* `Product Fee <product_fee.rst>`_
