.. _top:
.. title:: Notification

`Back to index <index.rst>`_

============
Notification
============

.. contents::
    :local:


List Notifications Subscriptions
````````````````````````````````

.. code-block:: php
    
    $notificationType = 'ORDER_CHANGE';
    $results = $client->notification->list($notificationType);


Get Notifications Subscription
``````````````````````````````

.. code-block:: php
    
    $notificationType = 'ORDER_CHANGE';
    $subscriptionId = '00000000-0000-0000-0000-000000000000';
    $results = $client->notification->get($notificationType, $subscriptionId);


Create Notifications Subscription
`````````````````````````````````

.. code-block:: php
    
    $notificationType = 'ORDER_CHANGE';
    $results = $client->notification->create($notificationType, [
        'payloadVersion' => '1.0',
        'destinationId' => '00000000-0000-0000-0000-000000000000',
        'processingDirective' => [
            'eventFilter' => [
                'orderChangeTypes' => [
                    'OrderStatusChange'
                ],
                'eventFilterType' => 'ORDER_CHANGE'
            ]
        ]
    ]);


Create Notification Destination
```````````````````````````````

.. code-block:: php
    
    $results = $client->notification->createDestination( [
        'resourceSpecification' => [
            'sqs' => [
                'arn' => 'arn:aws:sqs:us-east-2:444455556666:queue1'
            ]
        ],
        'name' => 'Trailerplus'
    ]);


Delete Notifications Subscription
`````````````````````````````````

.. code-block:: php
    
    $notificationType = 'ORDER_CHANGE';
    $subscriptionId = '00000000-0000-0000-0000-000000000000';
    $results = $client->notification->delete($notificationType, $subscriptionId);


List Notification Destinations
``````````````````````````````

.. code-block:: php
    
    $results = $client->notification->destinations();



Get Notification Destination
````````````````````````````

.. code-block:: php
    
    $destinationId = '00000000-0000-0000-0000-000000000000';
    $results = $client->notification->deleteDestination($destinationId);


Create Notification Destination
```````````````````````````````

.. code-block:: php
    
    $results = $client->notification->createDestination( [
        'resourceSpecification' => [
            'sqs' => [
                'arn' => 'arn:aws:sqs:us-east-2:444455556666:queue1'
            ]
        ],
        'name' => 'Trailerplus'
    ]);


Delete Notification Destination
```````````````````````````````

.. code-block:: php
    
    $destinationId = '00000000-0000-0000-0000-000000000000';
    $results = $client->notification->deleteDestination($destinationId);


`Back to top <#top>`_