.. _top:
.. title:: Finance

`Back to index <index.rst>`_

=======
Finance
=======

.. contents::
    :local:


Get Financial Events by OrderId
```````````````````````````````

.. code-block:: php
    
    $orderId = '000-0000000-0000000';
    $results = $client->finance->getEventsByOrderId($orderId);
