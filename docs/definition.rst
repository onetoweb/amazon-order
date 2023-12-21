.. _top:
.. title:: Definition

`Back to index <index.rst>`_

==========
Definition
==========

.. contents::
    :local:


Get Product Types
`````````````````

.. code-block:: php
    
    $results = $client->definition->getProductTypes([
        'marketplaceIds' => 'A1805IZSGTT6HS'
    ]);


Get Product Type
````````````````

.. code-block:: php
    
    $results = $client->definition->getProductType('CAR_PARTS_AND_ACCESSORIES', [
        'marketplaceIds' => 'A1805IZSGTT6HS',
    ]);


`Back to top <#top>`_