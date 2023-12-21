.. _top:
.. title:: Catalog

`Back to index <index.rst>`_

=======
Catalog
=======

.. contents::
    :local:


Search Items
````````````

.. code-block:: php
    
    $results = $client->catalog->searchItems([
        'keywords' => 'keyword',
        'marketplaceIds' => 'A1805IZSGTT6HS'
    ]);


Get Item
````````

.. code-block:: php
    
    $asin = '{asin}';
    $results = $client->catalog->getItem($asin, [
        'marketplaceIds' => 'A1805IZSGTT6HS',
        'includedData' => 'attributes, dimensions, identifiers, images, productTypes, relationships, salesRanks, summaries'
    ]);


`Back to top <#top>`_