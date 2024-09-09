.. _top:
.. title:: Order

`Back to index <index.rst>`_

=====
Order
=====

.. contents::
    :local:


Search Orders
`````````````

.. code-block:: php
    
    $lastUpdatedAfter = (new DateTime('2023-01-01'))->format(\Onetoweb\AmazonOrder\Client::AMAZON_QUERY_DATE_FORMAT);
    $results = $client->order->search([
        'LastUpdatedAfter' => $lastUpdatedAfter,
        'MarketplaceIds' => 'A1805IZSGTT6HS'
    ]);


Search Orders by Seller Order Id
````````````````````````````````

.. code-block:: php
    
    $createdAfter = (new DateTime('2023-01-01'))->format(\Onetoweb\AmazonOrder\Client::AMAZON_QUERY_DATE_FORMAT);
    $results = $client->order->search([
        'CreatedAfter' => $createdAfter,
        'MarketplaceIds' => 'A1805IZSGTT6HS',
        'SellerOrderId' => '9999999',
    ]);


Get Order
`````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->get($orderId);


Get Order with restricted data elements
```````````````````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    
    // add the restricted data elements you want to read
    $restrictedDataElements = [
        'shippingAddress'
    ];
    
    $results = $client->order->get($orderId, $restrictedDataElements);


Get Order Buyer Info
````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->getBuyerInfo($orderId);


Get Order Address
`````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->getAddress($orderId);


Get Order Address with restricted data elements
```````````````````````````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    
    // add the restricted data elements you want to read
    $restrictedDataElements = [
        'shippingAddress'
    ];
    
    $results = $client->order->getAddress($orderId, $restrictedDataElements);


Get Order Items
```````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->getItems($orderId);


Get Order Items Buyer Info
``````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->getItemBuyerInfo($orderId);


Get Order Regulated Info
````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->getRegulatedInfo($orderId);


Create Shipment Confirmation
````````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $client->order->createShipmentConfirmation($orderId, [
        'marketplaceId' => 'A1805IZSGTT6HS',
        'codCollectionMethod' => '',
        'packageDetail' => [
            'packageReferenceId' => '123',
            'carrierCode' => 'UPS',
            'carrierName' => 'UPS',
            'shippingMethod' => 'SHIPPING',
            'trackingNumber' => '1Z86V8030385598957',
            'shipDate' => '2022-11-30T16:15:30Z',
            'shipFromSupplySourceId' => '057d3fcc-b750-419f-bbcd-4d340c60c430',
            'orderItems' => [
                [
                    'orderItemId' => '60696125413094',
                    'quantity' => 1
                ]
            ]
        ]
    ]);


`Back to top <#top>`_