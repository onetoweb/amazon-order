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


Get Order
`````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order->get($orderId);


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


`Back to top <#top>`_