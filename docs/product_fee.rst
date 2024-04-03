.. _top:
.. title:: Product Fee

`Back to index <index.rst>`_

===========
Product Fee
===========

.. contents::
    :local:


Estimate By Asin
````````````````

.. code-block:: php
    
    $identifier = '{unique_id}';
    $asin = '{asin}';
    $results = $client->productFee->estimateByAsin($asin, [
        'MarketplaceId' => 'A1805IZSGTT6HS',
        'IsAmazonFulfilled' => false,
        'Identifier' => $identifier,
        'PriceToEstimateFees' => [
            'ListingPrice' => [
                'CurrencyCode' => 'EUR',
                'Amount' => 42,
            ]
        ]
    ]);


Estimate By Sku
```````````````

.. code-block:: php
    
    $identifier = '{unique_id}';
    $sku = '{sku}';
    $client->productFee->estimateBySku($sku, [
        'MarketplaceId' => 'A1805IZSGTT6HS',
        'IsAmazonFulfilled' => false,
        'Identifier' => $identifier,
        'PriceToEstimateFees' => [
            'ListingPrice' => [
                'CurrencyCode' => 'EUR',
                'Amount' => 42,
            ]
        ]
    ]);
