.. _top:
.. title:: Report

`Back to index <index.rst>`_

======
Report
======

.. contents::
    :local:


List Reports
````````````

.. code-block:: php
    
    $results = $client->report->list([
        'reportTypes' => 'GET_FLAT_FILE_RETURNS_DATA_BY_RETURN_DATE',
    ]);


Create Report
`````````````

.. code-block:: php
    
    $results = $client->report->create([
        'reportType' => 'GET_FLAT_FILE_RETURNS_DATA_BY_RETURN_DATE',
        'dataStartTime' => (new \DateTime())->modify('-60 days')->format('Y-m-d\\TH:i:s\.v\Z'),
        'marketplaceIds' => ['A1805IZSGTT6HS'],
    ]);


Get Report
``````````

.. code-block:: php
    
    $reportId = '{report_id}';
    $results = $client->report->get($reportId);


Get Report Document
```````````````````

.. code-block:: php
    
    $documentId = '{document_id}';
    $results = $client->report->document($documentId);


`Back to top <#top>`_