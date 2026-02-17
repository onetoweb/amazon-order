.. _top:
.. title:: Order 2026

`Back to index <index.rst>`_

==========
Order 2026
==========

.. contents::
    :local:


Get all orders updated last month
`````````````````````````````````

.. code-block:: php
    
    $lastUpdatedAfter = (new DateTime())->modify('-1 month')->format(DateTime::ATOM);
    $results = $client->order2026->search([
        'lastUpdatedAfter' => $lastUpdatedAfter,
    ]);


Get order by id
```````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->order2026->get($orderId);


`Back to top <#top>`_