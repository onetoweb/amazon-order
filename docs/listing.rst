.. _top:
.. title:: Listing

`Back to index <index.rst>`_

=======
Listing
=======

.. contents::
    :local:


Get Listing Item
````````````````

.. code-block:: php
    
    $sellerId = '{seller_id}';
    $sku = '{sku}';
    $result = $client->listing->getItem($sellerId, $sku, [
        'marketplaceIds' => 'A1805IZSGTT6HS',
        'includedData' => 'summaries, attributes, issues, offers, fulfillmentAvailability, procurement'
    ]);


Patch Listing Item (update fulfillment availability quantity)
`````````````````````````````````````````````````````````````

.. code-block:: php
    
    $sellerId = '{seller_id}';
    $sku = '{sku}';
    $result = $client->listing->patchItem($sellerId, $sku, [
        'marketplaceIds' => 'A1805IZSGTT6HS',
        'issueLocale' => 'nl_NL',
    ], [
        'productType' => 'MECHANICAL_COMPONENTS',
        'patches' => [[
            'op' => 'replace',
            'path' => '/attributes/fulfillment_availability',
            'value' => [[
                'fulfillment_channel_code' => 'DEFAULT',
                'quantity' => 7,
                'marketplace_id' => 'A1805IZSGTT6HS'
            ]]
        ]]
    ]);


Delete Listing Item
```````````````````

.. code-block:: php
    
    $sellerId = '{seller_id}';
    $sku = '{sku}';
    $result = $client->listing->deleteItem($sellerId, $sku, [
        'marketplaceIds' => 'A1805IZSGTT6HS'
    ]);


`Back to top <#top>`_