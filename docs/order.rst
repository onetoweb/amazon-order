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
    $results = $client->searchOrders([
        'LastUpdatedAfter' => $lastUpdatedAfter,
        'MarketplaceIds' => 'A1805IZSGTT6HS'
    ]);


Get Order
`````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrder($orderId);


Get Order Buyer Info
````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrderBuyerInfo($orderId);


Get Order Address
`````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrderAddress($orderId);


Get Order Items
```````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrderItems($orderId);


Get Order Items Buyer Info
``````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrderItemsBuyerInfo($orderId);


Get Order Regulated Info
````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->getOrderRegulatedInfo($orderId);


`Back to top <#top>`_